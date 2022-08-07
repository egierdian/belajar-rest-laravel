<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Models\Siswa;
use Exception;

class SiswaController extends Controller
{
    //
    public function index(){
        $data = Siswa::all();
        if($data):
            return ApiFormatter::createApi('200','Success',$data);
        else:
            return ApiFormatter::createApi('400','Failed');
        endif;
    }
    public function save(Request $request){
        try {
            $request->validate = ([
                'nama' => 'required',
                'alamat' => 'required',
            ]);

            $siswa = Siswa::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'active' => 1
            ]);

            $data = Siswa::where('id','=',$siswa->id)->get();
            if($data):
                return ApiFormatter::createApi('200','Success',$data);
            else:
                return ApiFormatter::createApi('400','Failed');
            endif;
        } catch (Exception $err) {
            return ApiFormatter::createApi('400','Failed', $err);
        }
    }
    public function get_by_id($id){
        try {
            $data = Siswa::where('id','=',$id)->get();
            if(count($data) > 0):
                return ApiFormatter::createApi('200','Success',$data);
            else:
                return ApiFormatter::createApi('400','Failed');
            endif;
        } catch (Exception $err) {
            return ApiFormatter::createApi('400','Failed', $err);
        }
    }

    public function update(Request $request, $id){
        try {
            $request->validate = ([
                'nama' => 'required',
                'alamat' => 'required',
            ]);

            $siswa = Siswa::findOrFail($id);
            $siswa = $siswa->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
            ]);

            $data = Siswa::where('id','=',$id)->get();
            if($data):
                return ApiFormatter::createApi('200','Success',$data);
            else:
                return ApiFormatter::createApi('400','Failed','ddd');
            endif;
        } catch (Exception $err) {
            return ApiFormatter::createApi('400','Failed', $err);
        }
    }
    public function delete($id){
        try {
            $siswa = Siswa::findOrFail($id);
            $siswa = $siswa->delete();

            $data = Siswa::where('id','=',$id)->get();
            if($data):
                return ApiFormatter::createApi('200','Success');
            else:
                return ApiFormatter::createApi('400','Failed');
            endif;
        } catch (Exception $err) {
            return ApiFormatter::createApi('400','Failed', $err);
        }

    }
}
