<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<table class='table table-bordered'>
    <thead>
        <tr>
            <td>Transction Date</td>
            <td>Description</td>
            <td>Credit</td>
            <td>Debit</td>
            <td>Amount</td>
        </tr>

    </thead>
    <tbody>
        @foreach ($transactions as $transaction)
            <tr>
                <td>{{ date('d-m-Y H:i',strtotime($transaction->created_at)) }}</td>
                <td> {{ $transaction->description }} </td>
                <td>{{ $transaction->debitcredit=="credit"?number_format($transaction->amount):"-" }}</td>
                <td>{{ $transaction->debitcredit=="debit"?number_format($transaction->amount):"-" }}</td>
                <td>{{ number_format($transaction->amount) }}</td>
            </tr>    
        @endforeach
    </tbody>
</table>