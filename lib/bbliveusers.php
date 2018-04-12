<?php
/**
 * This file is part of BlackBean LiveUsers <https://github.com/blackbean/BBLiveUsers>, a plugin
 * for the Moodle LMS Platform <https://www.moodle.org> that monitors the exact number of online
 * users per course in realtime, even if they spend hours watching a single video, for example,
 * without ever refreshing a single page. Copyright (C) 2018 by BlackBean Technologies Ltda.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, either version
 * 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU
 * General Public License along with this program.
 * If not, see https://www.gnu.org/licenses/
 */

/**
 * @package local_bbliveusers
 * @author Bruno Magalhães <brunomagalhaes@blackbean.com.br>
 * @copyright BlackBean Technologies Ltda <https://www.blackbean.com.br>
 * @license http://www.gnu.org/copyleft/gpl.html
 */
class bbliveusers
{
	/**
	 * [get_categories]
	 * 
	 * @param integer $category_id
	 * @return array
	 */
	public static function get_categories($category_id = 0)
	{
		/**
		 * 
		 */
		global $DB;
		
		/**
		 * 
		 */
		$category_id = max(0, (integer)$category_id);

		/**
		 *
		 */
		$categories = [];

		/**
		 * 
		 */
		$sql = "SELECT tb1.id,".
					"tb1.name AS name ".
				"FROM {course_categories} AS tb1 ".
				"WHERE tb1.parent<=>? ".
				"AND tb1.visible<=>1 ".
				"ORDER BY tb1.sortorder ASC";

		/**
		 *
		 */
		if($results = $DB->get_records_sql($sql, [$category_id]))
		{
			/**
			 *
			 */
			foreach($results as $result)
			{
				/**
				 *
				 */
				$category = new stdclass();
				$category->id = (integer)$result->id;
				$category->name = (string)$result->name;

				/**
				 *
				 */
				$categories[$category->id] = $category;
			}
		}

		/**
		 * 
		 */
		return($categories);
	}

	/**
	 * [get_courses]
	 * 
	 * @param integer $category_id
	 * @return array
	 */
	public static function get_courses($category_id = 0)
	{
		/**
		 * 
		 */
		global $DB;
		
		/**
		 * 
		 */
		$category_id = max(0, (integer)$category_id);

		/**
		 *
		 */
		$courses = [];

		/**
		 * 
		 */
		$sql = "SELECT tb1.id,".
					"tb1.fullname AS name ".
				"FROM {course} AS tb1 ".
				"WHERE tb1.category<=>? ".
				"AND tb1.visible<=>1 ".
				"ORDER BY tb1.sortorder ASC";

		/**
		 *
		 */
		if($results = $DB->get_records_sql($sql, [$category_id]))
		{
			/**
			 *
			 */
			foreach($results as $result)
			{
				/**
				 *
				 */
				$course = new stdclass();
				$course->id = (integer)$result->id;
				$course->name = (string)$result->name;

				/**
				 *
				 */
				$courses[$course->id] = $course;
			}
		}

		/**
		 * 
		 */
		return($courses);
	}

	/**
	 * [store_liveuser]
	 * 
	 * @param integer $course_id
	 * @param integer $user_id
	 * @param integer $step
	 * @return boolean
	 */
	public static function store_liveuser($course_id = 0, $user_id = 0, $step = 20)
	{
		/**
		 * 
		 */
		global $DB;

		/**
		 * 
		 */
		$course_id = max(0, (integer)$course_id);
		$user_id = max(0, (integer)$user_id);
		$step = max(20, (integer)$step);
		$user_time = time();
		$user_time = ($user_time - ($user_time % $step));

		/**
		 * 
		 */
		if($course_id == 0 or 
			$course_id == 1 or 
			$user_id == 0)
		{
			return(false);
		}

		/**
		 * 
		 */
		$sql = "REPLACE INTO {bbliveusers} ".
				"(course_id,user_id,user_time) ".
				"VALUES (?,?,?)";

		/**
		 * 
		 */
		return($DB->execute($sql, [$course_id, $user_id, $user_time]));
	}

	/**
	 * [count_liveusers]
	 * 
	 * @param integer $course_id
	 * @param integer $start
	 * @param integer $stop
	 * @param integer $step
	 * @return integer
	 */
	public static function count_liveusers($course_id = 0, $start = 0, $stop = PHP_INT_MAX, $step = 20)
	{
		/**
		 * 
		 */
		global $DB;

		/**
		 * 
		 */
		$course_id = max(0, (integer)$course_id);
		$start = max(0, (integer)$start);
		$stop = max(0, (integer)$stop);
		$step = max(20, (integer)$step);
		$start = ($start - ($start % $step));
		$stop = ($stop - ($stop % $step));

		/**
		 * 
		 */
		if($course_id > 1)
		{
			/**
			 * 
			 */
			$sql = "SELECT COUNT(DISTINCT tb1.user_id) AS total ".
					"FROM {bbliveusers} AS tb1 ".
					"WHERE tb1.course_id=? ".
					"AND tb1.user_time>=? ".
					"AND tb1.user_time<=?";

			/**
			 * 
			 */
			$params = [$course_id, $start, $stop];
		}
		else
		{
			/**
			 * 
			 */
			$sql = "SELECT COUNT(DISTINCT tb1.user_id) AS total ".
					"FROM {bbliveusers} AS tb1 ".
					"WHERE tb1.user_time>=? ".
					"AND tb1.user_time<=?";

			/**
			 * 
			 */
			$params = [$start, $stop];
		}

		/**
		 *
		 */
		if($result = $DB->get_record_sql($sql, $params))
		{
			/**
			 *
			 */
			return((integer)$result->total);
		}

		/**
		 * 
		 */
		return(0);
	}

	/**
	 * [fetch_liveusers]
	 * 
	 * @param integer $course_id
	 * @param integer $start
	 * @param integer $stop
	 * @param integer $step
	 * @return array
	 */
	public static function fetch_liveusers($course_id = 0, $start = 0, $stop = PHP_INT_MAX, $step = 20)
	{
		/**
		 * 
		 */
		global $DB;

		/**
		 * 
		 */
		$course_id = max(0, (integer)$course_id);
		$start = max(0, (integer)$start);
		$stop = max(0, (integer)$stop);
		$step = max(20, (integer)$step);
		$start = ($start - ($start % $step));
		$stop = ($stop - ($stop % $step));
		$time = time();
		$users = [];

		/**
		 * 
		 */
		if($course_id > 1)
		{
			/**
			 * 
			 */
			$sql = "SELECT tb2.id,".
						"tb2.firstname,".
						"tb2.lastname,".
						"MIN(tb1.user_time) AS first,".
						"MAX(tb1.user_time) AS last,".
						"(MAX(tb1.user_time) - MIN(tb1.user_time)) AS total,".
						"COUNT(DISTINCT tb1.user_time) AS count ".
					"FROM {bbliveusers} AS tb1 ".
					"INNER JOIN {user} AS tb2 ".
					"ON tb2.id=tb1.user_id ".
					"WHERE tb1.course_id=? ".
					"AND tb1.user_time>=? ".
					"AND tb1.user_time<=? ".
					"GROUP BY tb1.user_id ".
					"ORDER BY tb2.firstname";

			/**
			 * 
			 */
			$params = [$course_id, $start, $stop];
		}
		else
		{
			/**
			 * 
			 */
			$sql = "SELECT tb2.id,".
						"tb2.firstname,".
						"tb2.lastname,".
						"MIN(tb1.user_time) AS first,".
						"MAX(tb1.user_time) AS last,".
						"(MAX(tb1.user_time) - MIN(tb1.user_time)) AS total,".
						"COUNT(DISTINCT tb1.user_time) AS count ".
					"FROM {bbliveusers} AS tb1 ".
					"INNER JOIN {user} AS tb2 ".
					"ON tb2.id=tb1.user_id ".
					"WHERE tb1.user_time>=? ".
					"AND tb1.user_time<=? ".
					"GROUP BY tb1.user_id ".
					"ORDER BY tb2.firstname";

			/**
			 * 
			 */
			$params = [$start, $stop];
		}

		/**
		 *
		 */
		if($results = $DB->get_records_sql($sql, $params))
		{
			/**
			 *
			 */
			foreach($results as $result)
			{
				/**
				 *
				 */
				$user = new stdclass();
				$user->id = (integer)$result->id;
				$user->firstname = (string)$result->firstname;
				$user->lastname = (string)$result->lastname;
				$user->first = (integer)$result->first;
				$user->last = (integer)$result->last;
				$user->total = (integer)$result->total;
				$user->count = (integer)$result->count;

				/**
				 *
				 */
				$users[$user->id] = $user;
			}
		}

		/**
		 * 
		 */
		return($users);
	}

	/**
	 * [group_liveusers]
	 * 
	 * @param integer $course_id
	 * @param integer $start
	 * @param integer $stop
	 * @param integer $step
	 * @return array
	 */
	public static function group_liveusers($course_id = 0, $start = 0, $stop = PHP_INT_MAX, $step = 20)
	{
		/**
		 * 
		 */
		global $DB;

		/**
		 * 
		 */
		$course_id = max(0, (integer)$course_id);
		$start = max(0, (integer)$start);
		$stop = max(0, (integer)$stop);
		$step = max(20, (integer)$step);
		$start = ($start - ($start % $step));
		$stop = ($stop - ($stop % $step));
		$time = time();
		$stats = [];

		/**
		 * 
		 */
		if($course_id > 1)
		{
			/**
			 * 
			 */
			$sql = "SELECT (tb1.user_time-(tb1.user_time%".$step.")) AS time,".
						"MIN(tb1.user_time) AS first,".
						"MAX(tb1.user_time) AS last,".
						"COUNT(DISTINCT tb1.user_id) AS total ".
					"FROM {bbliveusers} AS tb1 ".
					"WHERE tb1.course_id=? ".
					"AND tb1.user_time>=? ".
					"AND tb1.user_time<=? ".
					"GROUP BY (tb1.user_time-(tb1.user_time%".$step."))";

			/**
			 * 
			 */
			$params = [$course_id, $start, $stop];
		}
		else
		{
			/**
			 * 
			 */
			$sql = "SELECT (tb1.user_time-(tb1.user_time%".$step.")) AS time,".
						"MIN(tb1.user_time) AS first,".
						"MAX(tb1.user_time) AS last,".
						"COUNT(DISTINCT tb1.user_id) AS total ".
					"FROM {bbliveusers} AS tb1 ".
					"WHERE tb1.user_time>=? ".
					"AND tb1.user_time<=? ".
					"GROUP BY (tb1.user_time-(tb1.user_time%".$step."))";

			/**
			 * 
			 */
			$params = [$start, $stop];
		}


		/**
		 *
		 */
		if($results = $DB->get_records_sql($sql, $params))
		{
			/**
			 *
			 */
			foreach($results as $result)
			{
				/**
				 *
				 */
				$stat = new stdclass();
				$stat->time = (integer)$result->time;
				$stat->first = (integer)$result->first;
				$stat->last = (integer)$result->last;
				$stat->total = (integer)$result->total;

				/**
				 *
				 */
				$stats[$stat->time] = $stat;
			}
		}

		/**
		 * 
		 */
		return($stats);
	}
}