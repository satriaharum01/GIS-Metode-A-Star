<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Cordinat;

use App\Models\Graf;
use App\Models\Halte;
use App\Models\Node;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Http\Controllers\Algorithm;
use App\Models\Koridor;

class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        $this->data['page'] = 'Front';
        $this->data['koridor'] = Koridor::select('*')->get();
        return view('front.index', $this->data);
    }

    public function halte()
    {
        $this->data['haltes'] = $this->halte_json(1);
        return view('front.halte', $this->data);
    }

    public function bus()
    {
        $this->data['buses'] = $this->bus_json(1);
        return view('front.bus', $this->data);
    }

    public function halte_detail($id)
    {
        $this->data['halte'] = $this->get_halte($id);
        return view('front.halte-detail', $this->data);
    }

    public function bus_detail($id)
    {
        $this->data['bus'] = $this->get_bus($id);
        return view('front.bus-detail', $this->data);
    }

    public function halte_json($limit)
    {
        $nlimit = $limit * 4;
        $data = Halte::select('*')
            ->limit($nlimit)
            ->get();
        foreach ($data as $row) {
            if ($row->Koridor->nama) {
                $row->koridor_nama = $row->Koridor->nama . $row->Koridor->kode;
            } else {
                $row->koridor_nama = 'Tidak Ditemukan';
            }
            $row->koridor_nama = $row->Koridor->nama . $row->Koridor->kode;
            $row->lat = $row->Node->latitude;
            $row->lng = $row->Node->longitude;
            $row->to_html = '<div class="col-12 col-md-3 mb-4">
                <div class="card" >
            <div class="card-body d-flex flex-column justify-content-between" style="height:240px;"\>
                    <div>
                        <h5 class="card-title fw-bold">' . $row->nama . '</h5>
                        <h6 class="card-title">' . $row->kode . '</h6>
                        <p class="card-text">' . $row->lokasi . '</p>
                    </div>
                    <a href="' . url("halte/detail/" . $row->id) . '" class="btn btn-primary">Detail</a>
                </div>
           </div>
            </div>';
        }

        return $data;
    }

    public function bus_json($limit)
    {
        $nlimit = $limit * 4;
        $data = Bus::select('*')
            ->limit($nlimit)
            ->get();
        foreach ($data as $row) {
            if ($row->Koridor->nama) {
                $row->koridor_nama = $row->Koridor->nama . $row->Koridor->kode;
            } else {
                $row->koridor_nama = 'Tidak Ditemukan';
            }
            $row->koridor_nama = $row->Koridor->nama . $row->Koridor->kode;
            $row->to_html = '<div class="col-12 col-md-3 mb-4">
                <div class="card" >
            <div class="card-body d-flex flex-column justify-content-between" style="height:240px;"\>
                    <div>
                        <h5 class="card-title fw-bold">' . $row->lambung . '</h5>
                        <h6 class="card-title">' . $row->koridor_nama . '</h6>
                        <p class="card-text">' . $row->tipe . '</p>
                    </div>
                    <a href="' . url("bus/detail/" . $row->id) . '" class="btn btn-primary">Detail</a>
                </div>
           </div>
            </div>';
        }

        return $data;
    }

    public function halte_search($key)
    {
        $data = Halte::select('*')
            ->where('nama', 'like', "%$key%")
            ->get();
        foreach ($data as $row) {
            $row->to_html = '<div class="col-12 col-md-3 mb-4">
                <div class="card" >
            <div class="card-body d-flex flex-column justify-content-between" style="height:240px;"\>
                    <div>
                        <h5 class="card-title fw-bold">' . $row->nama . '</h5>
                        <h6 class="card-title">' . $row->kode . '</h6>
                        <p class="card-text">' . $row->lokasi . '</p>
                    </div>
                    <a href="' . url("halte/detail/" . $row->id) . '" class="btn btn-primary">Detail</a>
                </div>
           </div>
            </div>';
        }

        return $data;
    }

    public function bus_search($key)
    {
        $data = Bus::select('*')
            ->where('lambung', 'like', "%$key%")
            ->get();
        foreach ($data as $row) {
            if ($row->Koridor->nama) {
                $row->koridor_nama = $row->Koridor->nama . $row->Koridor->kode;
            } else {
                $row->koridor_nama = 'Tidak Ditemukan';
            }
            $row->to_html = '<div class="col-12 col-md-3 mb-4">
                <div class="card" >
            <div class="card-body d-flex flex-column justify-content-between" style="height:240px;"\>
                    <div>
                        <h5 class="card-title fw-bold">' . $row->lambung . '</h5>
                        <h6 class="card-title">' . $row->koridor_nama . '</h6>
                        <p class="card-text">' . $row->tipe . '</p>
                    </div>
                    <a href="' . url("bus/detail/" . $row->id) . '" class="btn btn-primary">Detail</a>
                </div>
           </div>
            </div>';
        }

        return $data;
    }

    public function get_halte($id)
    {
        $data = Halte::find($id);

        return $data;
    }

    public function get_bus($id)
    {
        $data = Bus::find($id);
        $jam_start = str_replace('.', ':', substr($data->jam_operasional, 0, 5));
        $jam_end = str_replace('.', ':', substr($data->jam_operasional, -5));
        $jam_now = date('H:i');
        if ($jam_now > $jam_start && $jam_now < $jam_end) {
            $data->status = '<b style="color:green;">Sedang Beroperasi</b>';
        } else {
            $data->status = '<b style="color:red;">Tidak Beroperasi</b>';
        }
        return $data;
    }

    //Routes
    public function getShortestPath()
    {
        $grafModel = new Graf();
        $astar = new Astar();
        $path = explode(',', $astar->printPath());

        $result = array();
        $result['coordinates'] = [];
        $result['keterangan'] = [];
        $result['path'] = [];
        $result['distance'] = round($astar->getDistance() / 1000, 2) . 'Km';
        $result['perhitungan'] = $astar->getDetailPerhitungan();

        for ($i = 0; $i < count($path) - 1; $i++) {
            $graf = $grafModel->getByStartEnd($path[$i], $path[$i + 1]);
            array_push($result['coordinates'], $graf->rute);
            array_push($result['keterangan'], $graf->keterangan);
            array_push($result['path'], ($graf->start_nama ?? 'Node ' . $graf->start) . ' <i class="bi bi-arrow-right"></i> ' . ($graf->end_nama ?? 'Node ' . $graf->end));
        }

        echo json_encode($result);
        // print $astar->printPath();
        // print "\n";
        // print $astar->getDistance();
        // print "\n";
        // print $astar->getDetailPerhitungan();
    }

    public function node_json_map()
    {
        $data = Node::select('node.id', 'halte.nama as halte_id', 'node.latitude', 'node.longitude')
            ->leftJoin('halte', function ($join) {
                $join->on('halte.node_id', '=', 'node.id');
            })
            ->where('halte.node_id', '=', null)
            ->get();
        /*
        $data = Node::select('node.id', 'halte.nama as halte_id', 'node.latitude', 'node.longitude')
            ->leftJoin('halte', function ($join) {
                $join->on('halte.node_id', '=', 'node.id');
            })
            ->get();
        */
        return json_encode($data);
    }

    public function halte_json_map()
    {
        $data = Halte::select('*')
            ->get();
        foreach ($data as $row) {
            $row->latitude = $row->Node->latitude;
            $row->longitude = $row->Node->longitude;
            $row->halte_id = $row->nama;
        }

        return json_encode($data);
    }

    public function get_path($start, $end)
    {
        $data = Graf::select('*')
            ->where('start', '=', $start)
            ->where('end', '=', $end)
            ->get();

        foreach ($data as $row) {
            $new = array();
            $end_nama = Halte::where('node_id', '=', $row->end)->max('nama');
            $start_nama = 'Node ' . $row->start;
            foreach (json_decode($row->rute) as $temp) {
                $new[] = Cordinat::find($temp);
            }
            $row->rute_list = $start_nama . '->';
            foreach ($new as $n) {
                if (!next($new)) {
                    $row->rute_list .= $n['keterangan'] . '->' . $end_nama;
                } else {
                    $row->rute_list .= $n['keterangan'] . '->';
                }
            }
        }

        return json_encode($data);
    }
    public function get_jarak($start, $end)
    {
        $data = Graf::select('*')
            ->where('start', '=', $start)
            ->where('end', '=', $end)
            ->get();

        foreach ($data as $row) {
            $new = array();
            $new[] = Node::find($row->start);
            foreach (json_decode($row->rute) as $cord) {
                $new[] = Cordinat::find($cord);
            }
            $new[] = Node::find($row->end);
            $row->new = $new;
            unset($row->rute);
        }
        $jarak = array();
        foreach ($data as $row) {
            $astar = new Algorithm($row->new);
            $jarak[] = $astar->getjarak();
        }
        return json_encode($jarak);
    }
    public function get_cordinats($start, $end)
    {
        $shortPath = 100000;
        $index = 0;
        $data = Graf::select('*')
            ->where('start', '=', $start)
            ->where('end', '=', $end)
            ->get();
        $countData = count($data);
        if ($countData < 1) {
            return json_encode($data);
        }
        foreach ($data as $row) {
            $new = array();
            $new[] = Node::find($row->start);
            foreach (json_decode($row->rute) as $cord) {
                $new[] = Cordinat::find($cord);
            }
            $new[] = Node::find($row->end);
            $row->new = $new;
            unset($row->rute);
        }
        $jarak = array();
        foreach ($data as $row) {
            $astar = new Algorithm($row->new);
            $row->jarak = $astar->getjarak();
        }
        $i = 0;
        foreach ($data as $row) {
            $path = floatval($row->jarak['jarak']);
            if ($path <= $shortPath) {
                $shortPath = $path;
                $index = $i;
            }
            $i++;
        }

        $newPath = $data[$index];
        return json_encode($newPath->new);
    }

    public function filter_halte($id)
    {
        $out = array();
        if ($id == 0) {
            $data = Halte::select('*')->get();
        } else {
            $data = Halte::select('*')
                ->where('koridor', '=', $id)->get();
        }
        foreach ($data as $row) {
            $row->latitude = $row->Node->latitude;
            $row->longitude = $row->Node->longitude;
            $row->halte_id = $row->nama;
        }
        return $data;
    }

    public function filter_marker($id)
    {
        $out = array();
        $data = $this->filter_halte($id);
        if ($id == 0) {
            $out = Node::all();
            ;
        } else {
            foreach ($data as $row) {
                $dataTemp = Graf::select('*')->where('end', '=', $row->node_id)->get();
                foreach ($dataTemp as $p) {
                    $out[] = Node::find($p->start);
                }
            }
            $out = array_unique($out, SORT_REGULAR);
        }
        return $out;
    }

    public function opt_halte_json_map($id)
    {
        $graf = Graf::select('*')
            ->where('start', '=', $id)
            ->get('end');
        $searchArray = array();
        foreach ($graf as $row) {
            $searchArray[] = $row->end;
        }

        $data = Halte::select('*')
            ->whereIn('node_id', $searchArray)
            ->get();

        foreach ($data as $row) {
            $row->latitude = $row->Node->latitude;
            $row->longitude = $row->Node->longitude;
            $row->halte_id = $row->nama;
        }

        return json_encode($data);
    }

    public function opt_node_json_map($id)
    {
        $data = Node::select('*')
            ->where('id', '=', $id)
            ->get();

        return json_encode($data);
    }

    //Nearby Haltes
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
        return $c * $EARTH_RADIUS *1000;
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

    public function get_nearby($lat, $lng)
    {
        $origin = ["latitude"=>$lat,"longitude"=>$lng];
        $allhalte  = Halte::select('*')
                    ->get();
        foreach ($allhalte as $row) {
            $row->latitude = $row->Node->latitude;
            $row->longitude = $row->Node->longitude;
            $row->halte_id = $row->nama;
        };
        $showdistance = array();
        $searchArray = array();
        $analisis = array();
        $analisis[0] = $origin;
        foreach($allhalte as $row) {
            $analisis[1] = $row;
            $length = $this->distance($analisis);
            if ($length < 1000) {
                $showdistance[] = ["jarak" =>$length];
                $searchArray[]= $row->node_id;
            }
        }
        $count = count($showdistance);
        if($count==0){
            $showdistance[] = ["jarak" =>0];
            $data = null;
        }else{
            $columns = array_column($showdistance, 'jarak');
            array_multisort($columns, SORT_ASC, $showdistance);
            
            $data = Halte::select('*')
            ->whereIn('node_id', $searchArray)
            ->get();
            
            foreach ($data as $row) {
                $row->latitude = $row->Node->latitude;
                $row->longitude = $row->Node->longitude;
                $row->halte_id = $row->nama;
            }
        }
        
        for ($i = $count; $i > 5; $i--) {
            unset($showdistance[$i - 1]);
        }

        return json_encode($data);
    }
}
