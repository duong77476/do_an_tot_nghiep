@extends('admin.admin_layout')
@section('admin_content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('add-phieu-nhap') }}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm phiếu nhập
                </header>
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if($message){
                    echo $message;
                    \Illuminate\Support\Facades\Session::put('message',null);
                }
                ?>
                <div class="panel-body">
                    <div class="position-center">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" action="{{route('save-phieu-nhap')}}" method="post" >
                                    {{csrf_field()}}
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">Thông tin cơ bản phiếu nhập</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Date dd/mm/yyyy -->
                                        <div class="form-group">
                                            <label>Nhà cung cấp:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                </div>
                                                <select name="nha_cung_cap_id" id="nha_cung_cap_id" class="form-control">
{{--                                                    <option value="">---Chọn---</option>--}}
                                                @foreach($nha_cung_caps as $key=>$nha_cung_cap)
                                                        <option value="{{$nha_cung_cap->id}}">{{$nha_cung_cap->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->


                                        <div class="form-group">
                                            <label>Nội dung:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                </div>
                                                <input class="form-control" id="noi_dung" type="text" name="noi_dung" placeholder="Nhập nội dung">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                        <div class="form-group">
                                            <label>Trạng thái:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-square"></i></span>
                                                </div>
                                                <select class="form-control" name="trang_thai" >
                                                    <option value="Chưa xác nhận" selected>Chưa xác nhận</option>
                                                    <option value="Xác nhận">Xác nhận</option>
                                                </select>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                                <!-- Thông tin chi tiết phiếu nhập -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Sản phẩm</th>
                                                        <th>Số lượng yêu cầu</th>
                                                        <th>Số lượng thực nhập</th>
                                                        <th>Giá nhập</th>
                                                        <th>Thành tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="DynamicTable">
                                                    <tr>
                                                        <td>
                                                            <select id="san_pham" class="form-control" name="san_pham[]">
                                                                @foreach($products as $product)
                                                                    <option value="{{$product->id}}">{{$product->code}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                       <td>
                                                           <input type="number" class="form-control" name="so_luong_yeu_cau[]">
                                                       </td>
                                                        <td>
                                                            <input id="so_luong_thuc_nhap1" type="number" class="form-control so_luong" name="so_luong_thuc_nhap[]">
                                                            <button id="product_identity1" type="button" data-index="1" class="btn-product-indentity">Mã định danh</button>
                                                            <div id="container1" data-index="1">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control money gia_nhap" name="gia_nhap[]">
                                                        </td>
                                                        <td>
                                                            <input type="text" readonly class="form-control thanh_tien" name="thanh_tien[]">
                                                        </td>
                                                        <td>
                                                            <button type="button" id="add" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-primary form-control" value="Xác nhận và lưu">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

@endsection

@section('pagescript')
    <script type="text/javascript">
    $(document).ready(function (){
        var i = 1;
        $('#add').click(function (){
            i++;
            $('#DynamicTable').append('<tr id="row'+i+'"><td><select id="san_pham'+i+'" class="form-control" name="san_pham[]">@foreach($products as $product)<option value="{{$product->id}}">{{$product->code}}</option>@endforeach</select> </td> <td> <input type="number" class="form-control" name="so_luong_yeu_cau[]"> </td> <td> <input id="so_luong_thuc_nhap'+i+'" type="number" class="form-control so_luong" name="so_luong_thuc_nhap[]"><button id="product_identity'+i+'" type="button" data-index="'+i+'" class="btn-product-indentity">Mã định danh</button> <div id="container'+i+'" data-index="'+i+'"> </div> </td> <td> <input type="text" class="form-control money'+i+' gia_nhap"  name="gia_nhap[]"> </td> <td> <input readonly type="text" class="form-control thanh_tien" name="thanh_tien[]"> </td> <td> <button type="button" id="'+i+'" class="btn btn-danger remove_row"><i class="fa fa-minus"></i></button> </td> </tr>')
            new AutoNumeric('.money'+i+'', {
                currencySymbol :'đ',
                decimalPlaces: 2,
                digitGroupSeparator : ',',
                decimalCharacter : '.',
                currencySymbolPlacement : 's'
            });
            $('#san_pham'+i+'').selectize({
                sortField: "text",
            });
        });


        $(document).on('click','.remove_row',function (){
            var row_id = $(this).attr("id");
            $('#row'+row_id+'').remove();
        })
    })
</script>
<script>
    $(document).ready(function (){
        $("table").on("change", "input", function() {
            var row = $(this).closest("tr");
            var qty = parseFloat(row.find(".so_luong").val());
            var price_no_currency = row.find(".gia_nhap").val().replace("đ","");
            for(var i=0;i<price_no_currency.length;i++){
                if(price_no_currency[i].includes(",")){
                    price_no_currency = price_no_currency.replace(price_no_currency[i],"");
                }
            }
            var price_parsed = parseFloat(price_no_currency);
            var total = qty * price_parsed;
            row.find(".thanh_tien").val(isNaN(total) ? "" : total+'đ');
        });
    })
</script>
<script type="text/javascript">
    $('#san_pham').selectize({
        sortField: "text",
    });
    $("#nha_cung_cap_id").selectize({
        sortField: "text",
    });
</script>

    <script type='text/javascript'>
        $(document).on('click','.btn-product-indentity',function (){
            var id = $(this).data('index');
            var so_luong_thuc_nhap_id = 'so_luong_thuc_nhap'+id;
            var container_id = 'container'+id;
            addFields(so_luong_thuc_nhap_id,container_id);
        })
        function addFields(so_luong_thuc_nhap_id,container_id){
            // Generate a dynamic number of inputs
            var number = document.getElementById(so_luong_thuc_nhap_id).value;
            // Get the element where the inputs will be added to
            var container = document.getElementById(container_id);
            // Remove every children it had before
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
            for (i=0;i<number;i++){
                // Append a node with a random text
                container.appendChild(document.createTextNode("IMEI " + (i+1)));
                // Create an <input> element, set its type and name attributes
                var input = document.createElement("input");
                input.type = "text";
                input.name = so_luong_thuc_nhap_id+"imei" + i;
                container.appendChild(input);
                // Append a line break
                container.appendChild(document.createElement("br"));
            }
        }
    </script>

@endsection


