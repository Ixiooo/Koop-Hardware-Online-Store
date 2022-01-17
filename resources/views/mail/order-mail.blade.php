<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA=Compatible" content="ie=edge">
        <title> Koop Hardware Order Confirmation </title>
    </head>

    <body>
        <p>Hello, {{$order->first_name .' '. $order->middle_initial .'. '. $order->last_name}}</p>
        <p>Your Order has been successfully placed. The store will process the order right away.</p>
        <br>

        <table style="width: 600px; text-align: right;">
            <thead>
                <tr style="text-align: right;">
                    <th> Name </th>
                    <th> Quantity </th>
                    <th> Price </th>
                </tr>
            </thead>
            <tbody style="text-align: right;">
                @foreach ($order->orderItems as $item )
                    <tr>
                        <td>{{$item->product->product_name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td style="text-align: right;">₱ {{number_format($item->product->product_price * $item->quantity, 2)}}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="2"></td>
                        <td style="font-size: 22px; text-align: right; font-weight: bold;">Total: ₱ {{number_format($order->total,2)}}</td>
                    </tr>
            </tbody>
        </table>

    </body>
</html>