<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Doltech Gas Invoice System</title>
</head>

<style>
    .card-header {
        text-align: center;
    }
    table {
        width: 70%;
        margin: 0 20%;
        /* text-align: center; */
    }
    td{
     
    padding: 10px;  
    }
    .text-center{
        text-align: center;
    }
</style>

<body>
    <div class="center-container" id="print_area">
        <div class="card-header text-center border-0">
            <h2 class="" style=" font-size:40px; margin:0">Mattel Gas</h2>
            <small class="fs-3">Bigboy Junction University Road Tanke Ilorin, Kwara State</small>
            <h3 style="margin:10px 0; ">Transaction Receipt</h3>
        </div>
        <div class="table-wrapper">
            <table class="table">
                <tr class="col-md-6">
                    <td>ID: {{$transaction->transaction_id}}</td>
                    <td>Date: {{$transaction->created_at}}</td>
                </tr>
                <tr class="col-md-6">
                    <td>Name: {{$transaction->client->name}}</td>
                    <td>Phone: {{$transaction->client->phone}} </td>
                </tr>
                <tr class="col-md-6">
                    <td>Quantity: {{$transaction->quantity}} KG </td>
                    <td>Payment Method: {{$transaction->pay_method}}</td>
                </tr>
                <tr>
                    <td>Discount: {{$transaction->discount}} %</td>
                    <td>Transaction by: {{$transaction->user->name}}</td>
                </tr>
                <p></p>

            </table>
        </div>
        <div class="text-center">
            <h2 class="font-weight-bold">#{{number_format($transaction->price)}}</h2>
        </div>

    </div>
</body>

</html>