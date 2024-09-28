<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Arr;
use App\Models\Reseller;


class Algorithm extends Controller
{
    /**
     * Distributor Cordinates
     * @var array
     */
    private array $__distributor = array(
        'latitude'   => 3.574433873,
        'longitude'  => 98.69104255,
        'jarak'  => 0
    );
    /**
     * New Temp Array
     * @var array
     */
    private array $__temp = array();
    /**
     * Jarak
     * @var array
     */
    private array $__jarak = array();
    /**
     * Constant
     * @var array
     */
    private $__const = 111.319;
    /**
     * Constant
     * @var array
     */
    private $__count = 1;
    /**
     * Constant
     * @var array
     */
    private $__list = array();

    public function __construct($list)
    {
        $this->__list = $list;
        $datalist = $this->__list;
        //Equlident
        unset($this->__temp);
        $jarak = 0;
        $counter = count($datalist);
        foreach ($datalist as $data) {
            $this->__temp[] = $data;
        }
        for ($i = 1; $i < $counter; $i++) {
            $sampel = array();
            $sampel[0] = $this->__temp[$i - 1];
            $sampel[1] = $this->__temp[$i];

            $hasil = $this->__star($sampel);
            $jarak = $jarak + $hasil;
            //$this->__jarak[$this->__count][] = $hasil;
        }
        if($jarak < 1){
            $multiplier = ' Meter';
        }else{
            $multiplier = ' KM';
        }
        $this->__jarak['jarak'] = round($jarak,4). $multiplier;
        $this->__count++;
        //print_r($this->__temp);
    }

    public function __star(array $get)
    {
        $data = array();
        foreach ($get as $null) {
            $data[] = $null;
        }

        $vallat = $data[0]['latitude'] - $data[1]['latitude'];
        $vallong = $data[0]['longitude'] - $data[1]['longitude'];

        $power = pow($vallat, 2) + pow($vallong, 2);
        $sqrt = sqrt($power);
        $jarakHN = $this->distance($data);
        $result = $sqrt * $this->__const;
        $final = $result + $jarakHN;

        return $final;
    }

    public function getjarak()
    {
        return $this->__jarak;
    }

    public function shortestpath()
    {
        $list2 = $this->__list;
        $dataTemp = array();

        return $dataTemp;
    }

    public function _sort($array, $column)
    {
        usort($myArray, function ($a, $b) {
            return $a[$column] <=> $b[$column];
        });
    }

    public function indexes($array)
    {
        $i = 1;
        $j = 0;
        foreach ($array as $row) {
            $array[$j]['index'] = $i;
            $i++;
            $j++;
        }

        return $array;
    }

    public function get_length($origin, $destination)
    {
        // return distance in meters

        $lon1 = $this->toRadian($origin[1]);
        $lat1 = $this->toRadian($origin[0]);
        $lon2 = $this->toRadian($destination[1]);
        $lat2 = $this->toRadian($destination[0]);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;

        $a =   pow(sin($deltaLat / 2), 2) +   cos($lat1) *   cos($lat2) *   pow(sin($deltaLon / 2), 2);
        $c = 2 *   asin(sqrt($a));
        $EARTH_RADIUS = 6371;
        return $c * $EARTH_RADIUS;
    }
    public function toRadian($degree)
    {
        return $degree * (pi() / 180);
    }

    public function distance($data)
    {
        $distance = $this->get_length([$data[0]['latitude'], $data[0]['longitude']], [$data[1]['latitude'], $data[1]['longitude']]);
        return $distance;
    }

    public function objectArray($data)
    {
        $temp = array();
        foreach ($data as $row) {
            $array = json_decode(json_encode($row), true);
            $temp[] = $array;
        }
        return $temp;
    }

    public function equlident($data)
    {

        $vallat = $data[0]['latitude'] - $data[1]['latitude'];
        $vallong = $data[0]['longitude'] - $data[1]['longitude'];

        $power = pow($vallat, 2) + pow($vallong, 2);
        $sqrt = sqrt($power);
        $result = $sqrt * $this->__const;
        $gn = $this->distance($data);
        $final = $result + $gn;

        return $final;
    }
}
