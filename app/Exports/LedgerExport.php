<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;
use App\Models\Tabinfo;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\Bank;
use App\Models\Ledger;;

use App\Models\TicketType;
use App\Models\Passenger;
use App\Models\Price;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LedgerExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return ["SR", "Date", "Transaction", "Description", "Dep Date", "Arrival Date", "Debit", "Credit", "Balance", "Remarks"];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(40);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(13);
            },
        ];
    }
    public function collection()
    {
        $tabinfo = Tabinfo::where(['user_id' => Auth::user()->id, 'status_id' => 6])->get();
        foreach ($tabinfo as $info) {
            if ($info->tabtype_id == 5) {
                $info->payment = Payment::where('tabinfo_id', $info->id)->first();
                if ($info->payment) {
                    $info->payment->payment_history = PaymentHistory::where('payment_id', $info->payment->id)->first();
                    $info->payment->bank = Bank::find($info->payment->bank);
                }
            } else {
                $info->ledger = Ledger::where('tabinfo_id', $info->id)->first();
                if ($info->ledger) {
                    $ledger = Ledger::find($info->ledger->id);
                    $info->ticket_type = TicketType::find($ledger->ticketType_id);
                }

                $ledgerArrDate = $info->ledger ?  $info->ledger->arr_date : '';
                $ledgerDepDate = $info->ledger ?  $info->ledger->dep_date : '';
                // $pnr = $info->ledger ?  $info->ledger->pnr : '';
                $to = $info->ledger ?  $info->ledger->to : '';
                $from = $info->ledger ?  $info->ledger->from : '';
                // dd($ledgerArrDate);


                // dd($info->ticket_type);
                $info->passengers = Passenger::where('tabinfo_id', $info->id)->get();
                if ($info->passengers) {
                    foreach ($info->passengers as $passenger) {
                        $passenger->tabDate = $info->date;
                        $passenger->tab_name = $info->tabtype->tab_name;
                        $passenger->dep_date = $ledgerDepDate;
                        $passenger->arrival_date = $ledgerArrDate;
                        $passenger->pnr = $info->pnr;
                        $passenger->to = $to;
                        $passenger->from = $from;
                        $passenger->ticket_type = $info->ticket_type ? $info->ticket_type->name : '';
                        $passenger->payment_history = PaymentHistory::where('passenger_id', $passenger->id)->first();
                        $passenger->balance = Price::where('passenger_id', $passenger->id)->first();
                        if ($info->tabtype_id === 2) {
                            $info->credit = $passenger->balance->value;
                            $info->debit = '';
                        } else {
                            $info->debit = $passenger->balance->value;
                            $info->credit = '';
                        }
                    }
                } else {
                    $info->balance = NULL;
                }
            }
        }
        $data = User::find(Auth::user()->id);
        $customer = Customer::where('email', $data->email)->first();
        $csvData = [];
        if ($tabinfo) {
            $csvData = $tabinfo->map(function ($tab) {
                if ($tab->ledger && $tab->passengers) {
                    // $tabDate = $tab->date;
                    return $tab->passengers->map(function ($passenger) {
                        return [
                            'SR' => $passenger->payment_history ? $passenger->payment_history->id : '',
                            'Date' => $passenger->tabDate,
                            'Transaction' => $passenger->tab_name,
                            'Description' => !$passenger ? ' ' : $passenger->title . ' ' . $passenger->passenger_name . ' ' . $passenger->from . ' ' . $passenger->to . ' ' . $passenger->pnr . ' ' . $passenger->ticket_type,
                            'Dep Date' => $passenger->dep_date,
                            'Arrival Date' => $passenger->arrival_date,
                            'Debit' => $passenger->payment_history ? round($passenger->payment_history->debit) : '',
                            'Credit' => $passenger->payment_history ? round($passenger->payment_history->credit) : '',
                            'Balance' => $passenger->payment_history ? round($passenger->payment_history->balance) : '',
                            'Remarks' => $passenger->remarks
                        ];
                    });
                }
            });
            // foreach ($tabinfo as $tab) {
            //     if ($tab->ledger && $tab->passengers) {
            //         foreach ($tab->passengers as $passenger) {
            //             $arr = [
            //                 'SR' => $passenger->payment_history ? $passenger->payment_history->id : '',
            //                 'Date' => $tab->date,
            //                 'Transaction' => $tab->tabtype->tab_name,
            //                 'Description' => !$passenger ? '' : $passenger->title . '' . $passenger->passenger_name . '' . $tab->ledger->from . '' . $tab->ledger->to . '' . $tab->pnr . '' . $tab->ticket_type->name,
            //                 'Dep Date' => $tab->ledger ? $tab->ledger->dep_date : '',
            //                 'Arrival Date' => $tab->ledger ? $tab->ledger->arr_date : '',
            //                 'Debit' => $passenger->payment_history ? round($passenger->payment_history->debit) : '',
            //                 'Credit' => $passenger->payment_history ? round($passenger->payment_history->credit) : '',
            //                 'Balance' => $passenger->payment_history ? round($passenger->payment_history->balance) : '',
            //                 'Remarks' => $passenger->remarks
            //             ];
            //             array_push($csvData, $arr);
            //         }
            //     }
            //     // else {
            //     //     $arr = [
            //     //         'SR' => $tab->payment ? $tab->payment->payment_history->id : '',
            //     //         'Date' => $tab->payment ? $tab->payment->payment_date : '',
            //     //         'Transaction' => 'Credit',
            //     //         'Description' => 'ONLINE REDCIEVED IN SALAM TRAVEL ' . $tab->payment->bank->bank_name,
            //     //         'Dep Date' => '',
            //     //         'Arrival Date' => '',
            //     //         'Debit' => $tab->payment->payment_history ? round($tab->payment->payment_history->debit) : '',
            //     //         'Credit' => $tab->payment->payment_history ? round($tab->payment->payment_history->credit) : '',
            //     //         'Balance' => $tab->payment->payment_history ? round($tab->payment->payment_history->balance) : '',
            //     //         'Remarks' => $tab->payment->remarks
            //     //     ];
            //     //     array_push($csvData, $arr);
            //     // }
            // }
        }
        $csvData = $csvData->filter(function ($value, $key) {
            return $value != null;
        });
        // dd($csvData);
        return $csvData;
    }
}
