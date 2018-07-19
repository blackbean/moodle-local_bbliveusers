<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package local_bbliveusers
 * @author Bruno Magalhães <brunomagalhaes@blackbean.com.br>
 * @copyright BlackBean Technologies Ltda <https://www.blackbean.com.br>
 * @license http://www.gnu.org/copyleft/gpl.html
 */
defined('MOODLE_INTERNAL') || exit(0);

$string['Ymd'] = 'Y-m-d';
$string['His'] = 'H:i:s';
$string['YmdHis'] = 'Y-m-d H:i:s';
$string['pluginname'] = 'Usuários ao vivo';
$string['bbliveusers'] = 'Usuários ao vivo';
$string['local/bbliveusers'] = 'Usuários ao vivo';
$string['local_bbliveusers'] = 'Usuários ao vivo';
$string['bbliveusers:export'] = 'Exportar';
$string['local/bbliveusers:export'] = 'Exportar';
$string['local_bbliveusers:export'] = 'Exportar';
$string['bbliveusers:report'] = 'Reportar';
$string['local/bbliveusers:report'] = 'Reportar';
$string['local_bbliveusers:report'] = 'Reportar';
$string['title_settings'] = 'Usuários ao Vivo - Configurações';
$string['label_timeout'] = 'Tempo limite';
$string['help_timeout'] = 'A quantidade de segundos que esse plugin rastreará usuários inativos. Se for inferior a 5 minutos, é exatamente como para o plugin nativo Usuários Online, se for muito alto, a vida útil da sessão do usuário será perpetuada, o que pode ser considerado uma falha de segurança.';