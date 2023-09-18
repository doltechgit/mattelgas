<x-layout>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print_area,
            .print_area * {
                visibility: visible;
            }

        }
    </style>
    <div class="row m-2 ">
        <div class="card col-lg-6 col-md-12 mx-2 border-0 p-4">
            <div class="card-header border-0 d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="font-weight-bold">Transaction Details</h6>
                <div>
                    <!-- <a href="print_pdf/{{$transaction->id}}" class="btn btn-success  m-2"><i class="fa fa-print mx-2"></i>Print Invoice</a> -->
                    <button id="print_receipt" class="btn btn-success btn-sm  m-2"><i class="fa fa-print mx-2"></i>Print Invoice</button>
                    <a href="download_pdf/{{$transaction->id}}" class="btn btn-warning btn-sm m-2"><i class="fa fa-download mx-2"></i> Generate PDF</a>

                </div>
            </div>
            <table class="table p-0 m-0">
                <tr class="col-md-6 p-0">
                    <td>ID: {{$transaction->transaction_id}}</td>
                    <td>Date: {{$transaction->created_at}}</td>
                </tr>
                <tr class="col-md-6">
                    <td>Name: <a href="clients/{{$transaction->client->id}}">{{$transaction->client->name}}</a></td>
                    <td>Phone: {{$transaction->client->phone}} </td>
                </tr>
                <tr class="col-md-6">
                    <td>Quantity: {{$transaction->quantity}} KG </td>
                    <td>Payment Method:
                        @if ($transaction->pay_method == 'Paid')
                        @foreach ($transaction->methods as $method)
                        {{$method->method}} - &#8358; {{$method->amount}},
                        @endforeach
                        @else
                        {{$transaction->pay_method}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Discount: {{$transaction->discount}} %</td>
                    <td>Transaction by: {{$transaction->user == null ? 'Staff' : $transaction->user->name}}</td>
                </tr>
                <tr>
                    <td>Paid: &#8358; {{number_format($transaction->paid)}}</td>
                    <td>
                        Balance: &#8358; {{number_format($transaction->balance)}}
                        <!-- <a href="#">Pay Balance</a> -->
                    </td>
                </tr>
            </table>
            @if($transaction->balance > 0)
            <div class="my-2">
                <p class="m-0 font-weight-bold">Pay Balance</p>
                <hr>
                <form method="POST" action="/transactions/update/{{$transaction->id}}">
                    @csrf
                    <div class="form-group">
                        <label><small>Balance: </small></label>
                        <input class="form-control" type="number" name='balance' placeholder="&#8358; 000.000" value="{{$transaction->balance}}" />
                    </div>
                    <div class="form-group">
                        <label><small>Pay: </small></label>
                        <input class="form-control" type="number" name='paid' placeholder="&#8358; 000.000" />
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">Balance</button>
                </form>
            </div>
            @endif
        </div>
        <div class="card col-lg-5 col-md-12 mx-2 p-5 print_area border-0" id="print_area">
            <div class="card-header text-center border-0" style="text-align: center">
                <h2 class="text-uppercase h3 font-weight-bold my0" style="line-height: 10px;">Mattel Gas</h2>
                <small class="fs-3">Bigboy Junction University Road Tanke Ilorin, Kwara State</small>
                <h5>Transaction Receipt</h5>
            </div>
            <table class="table">
                <tr>
                    <td>ID: </td>
                    <td>{{$transaction->transaction_id}}</td>
                </tr>
                <tr>
                    <td>Date: </td>
                    <td>{{$transaction->created_at}}</td>
                </tr>
                <tr>
                    <td>Name: </td>
                    <td>{{$transaction->client->name}}</td>
                </tr>
                <tr>
                    <td>Phone: </td>
                    <td>{{$transaction->client->phone}} </td>
                </tr>
                <tr>
                    <td>Quantity: </td>
                    <td>{{$transaction->quantity}} KG </td>
                </tr>
                <tr>
                    <td>Payment Method:</td>
                    <td>
                        @if ($transaction->pay_method == 'Paid')
                        @foreach ($transaction->methods as $method)
                        {{$method->method}} - &#8358; {{$method->amount}},
                        @endforeach
                        @else
                        {{$transaction->pay_method}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Paid: </td>
                    <td>&#8358; {{$transaction->paid}}</td>
                </tr>
                <tr>
                    <td>To Bal: </td>
                    <td>&#8358; {{$transaction->balance}}</td>
                </tr>
                <tr>
                    <td>Discount: </td>
                    <td>{{$transaction->discount}} %</td>
                </tr>
                <tr>
                    <td>Transaction by: </td>
                    <td>{{$transaction->user == null ? 'Staff' : $transaction->user->name}}</td>
                </tr>
                <p></p>

            </table>
            <div class="text-center" style="text-align: center">
                <h2 class="font-weight-bold"> &#8358; {{number_format($transaction->price)}}</h2>
            </div>

        </div>


    </div>


    <script>
        $(document).ready(function() {
            $('#print_receipt').on('click', function() {
                let content = $("#print_area")
                let win_print = window.open('', '', 'width=302', 'height=450')
                win_print.document.write(content.html())
                win_print.document.close()
                win_print.print()
            })
        })
    </script>

</x-layout>