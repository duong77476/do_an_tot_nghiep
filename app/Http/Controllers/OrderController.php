<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\ChiTietPhieuNhap;
use App\Models\ChiTietPhieuTraHang;
use App\Models\ChiTietPhieuXuat;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PhieuTraHang;
use App\Models\PhieuXuat;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\StatisticOrder;
use App\Models\TonKho;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Symfony\Component\VarDumper\VarDumper;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders = Order::orderby('created_at','DESC')->get();
        return view('admin.order.index')->with('orders',$orders);
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $order = Order::find($id);
        $order_detail = OrderDetail::where('order_id',$id)->get();
        return view('admin.order.view')
            ->with('order',$order)
            ->with('order_detail',$order_detail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function print_order($id){
        //$pdf = App::make('dompdf.wrapper');
        $order = Order::find($id);
        $order_detail = OrderDetail::where('order_id',$id)->get();
        $pdf= \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.order.print_order',['order'=>$order,'order_detail'=>$order_detail])->setPaper('a4');
        //$view = (string)View::make('admin.order.print_order');
        //echo $view;
        return $pdf->stream();
        //return view('admin.order.print_order')->with(compact('order','order_detail'));
    }

    public function update_order_status(Request $request){
        //C???p nh???t tr???ng th??i ????n h??ng
        $data = $request->all();
        $order = Order::find($data['order_id']);

//        if($data['pre_order_status']=="??ang x??? l??" || $data['pre_order_status']=="??ang giao h??ng" || $data['pre_order_status']=="???? giao h??ng" ){
//
//        }
        if($data['order_status']=="??ang x??? l??"){
            $phieu_xuat = new PhieuXuat();
            $phieu_xuat->content = "Phi???u xu???t cho ????n h??ng m?? ".$data['order_id'];
            $phieu_xuat->order_id = $data['order_id'];
            $phieu_xuat->nguoi_lap_id = Auth::id();
            $phieu_xuat->tong_tien = $order->tong_tien;
            $phieu_xuat->created_at = now();
            $phieu_xuat->updated_at = now();
            $phieu_xuat->save();
            foreach ($data['order_product_id'] as $key=>$product_id){
                $product = Product::find($product_id);
                $chi_tiet_phieu_xuat = new ChiTietPhieuXuat();
                $chi_tiet_phieu_xuat->phieu_xuat_id = $phieu_xuat->id;
                $chi_tiet_phieu_xuat->product_id = $product_id;
                $chi_tiet_phieu_xuat->gia_xuat = $product->gia_ban;
                $chi_tiet_phieu_xuat->so_luong_yeu_cau = $data['order_product_qty'][$key];
                $chi_tiet_phieu_xuat->save();
            }
            $title = "????n h??ng "."#".$order->id." ??ang ???????c x??? l??";
            $this->send_mail_customer($order->id,$title);
        }else if($data['order_status']=="??ang giao h??ng"){
            $phieu_xuat = PhieuXuat::where('order_id',$order->id)->first();
            if(is_null($phieu_xuat))
                return response()->json(['error'=>'kh??ng c?? phi???u xu???t cho ????n h??ng n??y, b???n c???n t???o phi???u xu???t sau ???? m???i c?? th??? thay ?????i tr???ng th??i']);
            else if($phieu_xuat->trang_thai=="Ch??a x??c nh???n")
                return response()->json(['error'=>'Kh??ng th??? thay ?????i tr???ng th??i khi m?? phi???u xu???t ch??a ???????c x??c nh???n']);
            $title = "????n h??ng "."#".$order->id." ??ang ???????c giao";
            $this->send_mail_customer($order->id,$title);
        }else if($data['order_status']=="???? giao h??ng"){
            $phieu_xuat = PhieuXuat::where('order_id',$order->id)->first();
            if(is_null($phieu_xuat))
                return response()->json(['error'=>'kh??ng c?? phi???u xu???t cho ????n h??ng n??y, b???n c???n t???o phi???u xu???t sau ???? m???i c?? th??? thay ?????i tr???ng th??i']);
            else if($phieu_xuat->trang_thai=="Ch??a x??c nh???n")
                return response()->json(['error'=>'Kh??ng th??? thay ?????i tr???ng th??i khi m?? phi???u xu???t ch??a ???????c x??c nh???n']);

            //???? giao h??ng xong th?? update v??o b???ng statistic order
            //C???p nh???t s??? l?????ng mua, s???, t???ng s??? ????n h??ng, doanh thu, l???i nhu???n

            //T??nh l???i nhu???n
            $order_details = OrderDetail::where('order_id',$data['order_id'])->get();
            $sales = 0;
            $chi_phi = 0;

            foreach ($order_details as $order_detail){
                $now = Carbon::now();
                $product = Product::find($order_detail->product_id);
                $chi_tiet_phieu_nhaps = ChiTietPhieuNhap::where('product_id',$product->id)->whereDate('created_at','<=',$now->toDate())->whereDate('created_at','>=',$now->firstOfMonth()->toDate())->get();

                $so_luong_nhap = 0;
                $tong_tien_nhap = 0;
                foreach ($chi_tiet_phieu_nhaps as $chi_tiet_phieu_nhap){
                    $so_luong_nhap += $chi_tiet_phieu_nhap->so_luong_thuc_nhap;
                    $tong_tien_nhap += $chi_tiet_phieu_nhap->thanh_tien;
                }
//                //Tr?? ??i s??? l?????ng t???n
//                $product->so_luong -= $order_detail->so_luong;
//                $product->save();
//
//                //C???ng th??m v??o c???t xu???t trong th??ng ??? b???ng t???n kho
//                $month = \date("m");
//                $year = \date('Y');
//                $ton_kho_by_product = TonKho::where('product_id',$product->id)->where('year',$year)->where('month',$month)->first();
//                if(is_null($ton_kho_by_product)){
//                    $ton_kho_by_product = new TonKho();
//                    $ton_kho_by_product->year = $year;
//                    $ton_kho_by_product->month = $month;
//                    $ton_kho_by_product->ton_dau_thang = 0;
//                    $ton_kho_by_product->nhap_trong_thang = 0;
//                    $ton_kho_by_product->xuat_trong_thang = $order_detail->so_luong;
//                    $ton_kho_by_product->ton = 0;
//                    $ton_kho_by_product->product_id = $product->id;
//                }else{
//                    $ton_kho_by_product->xuat_trong_thang += $order_detail->so_luong;
//                }
//                $ton_kho_by_product->save();
            }

            $order_date = $order->order_date;
            $stat_order = StatisticOrder::where('order_date',$order_date)->first();
            if(is_null($stat_order)){
                $stat_order = new StatisticOrder();
                $stat_order->order_date = $order_date;
                $stat_order->sales = $order->tong_tien;
                $stat_order->quantity = $order->tong_so_luong;
                $stat_order->total_order = 1;
            }else{
                $stat_order->sales += $order->tong_tien;
                $stat_order->quantity += $order->tong_so_luong;
                $stat_order->total_order += 1;
            }
            $stat_order->save();
            $title = "????n h??ng "."#".$order->id." ???? giao th??nh c??ng";
            $this->send_mail_customer($order->id,$title);
        }
        else if($data['order_status']=="Ch??? x??c nh???n h???y"){
            $phieu_tra_hang = new PhieuTraHang();
            $phieu_tra_hang->content = "Phi???u ho??n tr??? cho ????n h??ng m?? ".$data['order_id'];
            $phieu_tra_hang->order_id = $data['order_id'];
            $phieu_tra_hang->nguoi_lap_id = Auth::id();
            $phieu_tra_hang->tong_tien = $order->tong_tien;
            $phieu_tra_hang->created_at = now();
            $phieu_tra_hang->updated_at = now();
            $phieu_tra_hang->save();
            foreach ($data['order_product_id'] as $key=>$product_id){
                $product = Product::find($product_id);
                $chi_tiet_phieu_tra_hang = new ChiTietPhieuTraHang();
                $chi_tiet_phieu_tra_hang->phieu_tra_hang_id = $phieu_tra_hang->id;
                $chi_tiet_phieu_tra_hang->product_id = $product_id;
                $chi_tiet_phieu_tra_hang->gia_xuat = $product->gia_ban;
                $chi_tiet_phieu_tra_hang->so_luong_trong_don_hang = $data['order_product_qty'][$key];
                $chi_tiet_phieu_tra_hang->save();
            }

            $title = "????n h??ng "."#".$order->id." ch??? x??c nh???n h???y";
            $this->send_mail_customer($order->id,$title);
        }else{
            $title = "????n h??ng "."#".$order->id." ???? h???y";
            $this->send_mail_customer($order->id,$title);
        }
        $order->trang_thai = $data['order_status'];
        $order->save();
    }

    public function send_mail_customer($order_id,$title){
        $order = Order::find($order_id);
        $order_detail = OrderDetail::where('order_id',$order_id)->get();
        Mail::send('frontend.checkout.mail_confirm_order',['title'=>$title,'order'=>$order,'order_detail'=>$order_detail],
            function ($message) use($order,$title){
                $message->to($order->customer->email)->subject($title);
                $message->from(env('MAIL_USERNAME'),$title);
            });
    }

    public function export_order($id){
        $order = Order::find($id);
        $order_export =  new OrderExport();
        $order_export->setID($order->id);
        return \Maatwebsite\Excel\Facades\Excel::download($order_export,'HoaDon.xlsx');
    }
}
