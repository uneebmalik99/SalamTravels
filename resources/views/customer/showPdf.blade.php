<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Travel
    </title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 4px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

    </style>
</head>

<body style="font-family: sans-serif !important;padding:0px; width:100%; ">
    <div class="wrapper " style="padding: 0px; margin:0px; width:100%; ">
        <div class="main-panel" id="main-panel" style="padding: 0px; margin:0px; width:100%; ">
            <div class="content" style="padding: 0px; margin:0px; width:100%; ">
                <div class="row" style="padding: 0px; margin:0px; width:100%; ">
                    <div class="col-md-12" style="padding: 0px; margin:0px; width:100%; ">
                        <div class="card" style="padding: 0px; margin:0px; width:100%; ">
                            <div class="card-body" style=" width:100%; ">
                                <div class="table-responsive" style=" width:100%; ">
                                    <table class="table" id="ledgerTable" style=" width:100%; ">
                                        <thead>
                                            <tr>
                                                <th>Sr.</th>
                                                <th>Date</th>
                                                <th>Transaction</th>
                                                <th>Description</th>
                                                <th>Dep. Date</th>
                                                <th>Arrival Date</th>
                                                <th>Debit</th>
                                                <th>Credit</th>
                                                <th>Balance</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data && isset($data))
                                                <?php $i = 1; ?>
                                                @foreach ($data as $record)
                                                    @if ($record->ledger && $record->passengers)
                                                        @foreach ($record->passengers as $passenger)
                                                            <tr>
                                                                <td>
                                                                    @if ($passenger->payment_history)
                                                                        {{ $passenger->payment_history->id }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ $record->date }}</td>
                                                                <td>
                                                                    @if ($record->ledger)
                                                                        {{ $record->tabtype->tab_name }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($passenger)
                                                                        {{ $passenger->title }}
                                                                        <span>{{ $passenger->passenger_name }}</span>
                                                                        ~
                                                                        <span>{{ $record->ledger->from }}</span> ~
                                                                        <span>{{ $record->ledger->to }}</span>~
                                                                        <span>{{ $record->pnr }}</span>~
                                                                        @if ($record->ticket_type && isset($record->ticket_type))
                                                                            <span>{{ $record->ticket_type->name }}</span>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($record->ledger)
                                                                        {{ $record->ledger->dep_date }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($record->ledger)
                                                                        {{ $record->ledger->arr_date }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($passenger->payment_history)
                                                                        {{ round($passenger->payment_history->debit) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($passenger->payment_history)
                                                                        {{ round($passenger->payment_history->credit) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($passenger->payment_history)
                                                                        {{ round($passenger->payment_history->balance) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($passenger && $passenger->remarks && isset($passenger->remarks))
                                                                        {{ $passenger->remarks }}
                                                                    @else
                                                                        No Remarks
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @elseif ($record->tabtype_id == 5 && $record->payment)
                                                        <tr>
                                                            <td>{{ $record->payment->payment_history->id }}</td>
                                                            <td>{{ $record->payment->payment_date }}</td>
                                                            <td>
                                                                Credit
                                                            </td>
                                                            <td>
                                                                ONLINE REDCIEVED IN SALAM TRAVEL
                                                                {{ $record->payment->bank->bank_name }}
                                                            </td>
                                                            <td>
                                                            </td>
                                                            <td>
                                                            </td>
                                                            <td>
                                                                @if ($record->payment->payment_history)
                                                                    {{ round($record->payment->payment_history->debit) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($record->payment->payment_history)
                                                                    {{ round($record->payment->payment_history->credit) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($record->payment->payment_history)
                                                                    {{ round($record->payment->payment_history->balance) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($record->payment && $record->payment->remarks && isset($record->payment->remarks))
                                                                    {{ $record->payment->remarks }}
                                                                @else
                                                                    No Remarks
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>No Date Found</tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <footer class="footer">
                <div class=" container-fluid ">
                    <div class="copyright" id="copyright">
                        @
                        <script>
                            document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                        </script>, Developed by <a href="https://therevolutiontechnologies.com"
                            target="_blank">The Revolution Technologies</a>
                    </div>
                </div>
            </footer> --}}
        </div>
    </div>

</body>

</html>
