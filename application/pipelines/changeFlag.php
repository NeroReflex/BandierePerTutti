<?php
/*
	BandierePerTutti set and reset flags!
    Copyright (C) 2016 Benato Denis

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

$pipeline = new \Gishiki\Pipeline\Pipeline('changeFlagStatus');

$pipeline->bindStage('changeStatus', function (\Gishiki\Algorithms\Collections\SerializableCollection &$data) {
    $flagName = $data->get('flag');
    $flagStatus = ($data->get('status') == true);
    
    $flags = json_decode(file_get_contents("flags.json"), true);
    $flags[$flagName] = $flagStatus;
    file_put_contents("flags.json", json_encode($flags, JSON_PARTIAL_OUTPUT_ON_ERROR));
});
