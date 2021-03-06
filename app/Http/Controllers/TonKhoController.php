<?php

namespace App\Http\Controllers;

use App\Exports\TonKhoExport;
use App\Models\Product;
use App\Models\TonKho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;
use Symfony\Component\VarDumper\VarDumper;

class TonKhoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ton_khos = TonKho::orderBy('trang_thai','ASC')->orderBy('month','ASC')->get();
        return view('admin.ton_kho.index')
            ->with('ton_khos',$ton_khos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TonKho  $tonKho
     * @return \Illuminate\Http\Response
     */
    public function show(TonKho $tonKho)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TonKho  $tonKho
     * @return \Illuminate\Http\Response
     */
    public function edit(TonKho $tonKho)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TonKho  $tonKho
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TonKho $tonKho)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TonKho  $tonKho
     * @return \Illuminate\Http\Response
     */
    public function destroy(TonKho $tonKho)
    {
        //
    }

    public function chot_ton_kho(){
        $date = date("Y-m-d");
        //L???y n??m, th??ng tr?????c
        $pre_month = date("m", strtotime ( '-1 month' , strtotime ( $date ) ));
        $pre_year = date("Y", strtotime ( '-1 month' , strtotime ( $date ) ));
        //L???y n??m th??ng hi???n t???i
        $month = date("m");
        $year = date('Y');
        $ton_khos = TonKho::where('trang_thai','Ch??a ho??n th??nh')->where('year',$pre_year)->where('month',$pre_month)->get();

        //TH: Kh??ng t???n t??i b???n ghi n??o c???a th??ng tr?????c, v?? d??? ??ang ??? th??ng 6 kh??ng c?? s??? l?????ng t???n c???a th??ng 5
        //Th?? m???c ?????nh c??c s???n ph???m t???n kho th??ng 5 c?? s??? li???u l?? 0
//        $products = Product::all();
//        foreach ($products as $product){
//            $san_pham_co_ton_kho_thang_truoc = TonKho::where('product_id',$product->id)->where('year',$pre_year)->where('month',$pre_month)->first();
//            if(is_null($san_pham_co_ton_kho_thang_truoc)){
//                $ton_kho_thang_truoc = new TonKho();
//                $ton_kho_thang_truoc->ton_dau_thang = 0;
//                $ton_kho_thang_truoc->year = $pre_year;
//                $ton_kho_thang_truoc->month = $pre_month;
//                $ton_kho_thang_truoc->nhap_trong_thang = 0;
//                $ton_kho_thang_truoc->xuat_trong_thang = 0;
//                $ton_kho_thang_truoc->trang_thai = "Ho??n th??nh";
//                $ton_kho_thang_truoc->ton = 0;
//                $ton_kho_thang_truoc->product_id = $product->id;
//                $ton_kho_thang_truoc->save();
//            }
//        }


        foreach ($ton_khos as $ton_kho){
            $ton_kho->ton = $ton_kho->nhap_trong_thang - $ton_kho->xuat_trong_thang;
            $ton_kho->trang_thai = "Ho??n th??nh";
            $ton_kho->save();
            //Ki??m tra d?? c?? b???n ghi t???n kho th???ng k?? c???a s???n ph???m c???a th??ng hi??n t???i ch??a
            //N???u c?? th?? ch??? c???n g???n s??? l?????ng t???n c???a b???n ghi th??ng tr?????c sang s??? l?????ng t???n ?????u th??ng c???a b???n ghi th??ng n??y
            //V?? kh??ng t???o m???i, ng?????c l???i s??? t???o m???i
            $exist_ton_kho = TonKho::where('product_id',$ton_kho->product_id)->where('year',$year)->where('month',$month)->first();
            if(!is_null($exist_ton_kho)) {
                $pre_ton_kho = TonKho::where('product_id', $exist_ton_kho->product_id)->where('year', $pre_year)->where('month', $pre_month)->first();
                $pre_ton_kho->ton = $pre_ton_kho->nhap_trong_thang - $pre_ton_kho->xuat_trong_thang;
                $exist_ton_kho->ton_dau_thang = $pre_ton_kho->ton;
                $exist_ton_kho->save();
            }
            else{
                $ton_kho_thang_toi = new TonKho();
                $ton_kho_thang_toi->ton_dau_thang = $ton_kho->ton;
                $ton_kho_thang_toi->year = $year;
                $ton_kho_thang_toi->month = $month;
                $ton_kho_thang_toi->nhap_trong_thang = 0;
                $ton_kho_thang_toi->xuat_trong_thang = 0;
                $ton_kho_thang_toi->ton = 0;
                $ton_kho_thang_toi->product_id = $ton_kho->product_id;
                $ton_kho_thang_toi->save();
            }
        }
    }

    public function export_csv(Request $request){
        $data = $request->all();
        $ton_kho = TonKho::where('trang_thai','Ho??n th??nh')->where('year',$data['year'])->where('month',$data['month'])->get();
        if(($ton_kho)->count()==0){
//            exit();
            Session::put('message','<p class="text-danger">Kh??ng t???n t???i b??o c??o</p>');
            return redirect()->to('ton-kho/all');
        }
        $ton_kho_export =  new TonKhoExport();
        $ton_kho_export->setYear($data['year']);
        $ton_kho_export->setMonth($data['month']);
        return \Maatwebsite\Excel\Facades\Excel::download($ton_kho_export,'BaoCaoTonKho.xlsx');
    }

    public function view_chi_tiet_nhap_xuat($id){
        $ton_kho = TonKho::find($id);
        $product = Product::find($ton_kho->product_id);
        return view('admin.ton_kho.chi_tiet_nhap_xuat')
            ->with(compact('ton_kho','product'));
    }
}
