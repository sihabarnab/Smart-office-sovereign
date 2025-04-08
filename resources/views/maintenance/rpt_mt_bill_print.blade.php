@php
    $product = $m_bill_details->count();
    $repair_price = $m_bill_master->repair_price > 0 ? 1 : 0;
    $previous_due = $m_bill_master->previous_due > 0 ? 1 : 0;
    $vat = $m_bill_master->vat > 0 ? 0 : 1;
    $countRaw = $product + $repair_price + $previous_due + $vat;
@endphp

@if ($countRaw > 16)
@include('maintenance.rpt_mt_bill_print_18_to_31')
@else
  @include('maintenance.rpt_mt_bill_print_17')
@endif


@php

    //Number to word BD Taka
    function convert_number($number)
    {
        $my_number = $number;

        if ($number < 0 || $number > 999999999) {
            throw new Exception('Number is out of range');
        }
        $Kt = floor($number / 10000000); /* Koti */
        $number -= $Kt * 10000000;
        $Gn = floor($number / 100000); /* lakh  */
        $number -= $Gn * 100000;
        $kn = floor($number / 1000); /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100); /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10); /* Tens (deca) */
        $n = $number % 10; /* Ones */

        $res = '';

        if ($Kt) {
            $res .= convert_number($Kt) . ' Koti ';
        }
        if ($Gn) {
            $res .= convert_number($Gn) . ' Lakh';
        }

        if ($kn) {
            $res .= (empty($res) ? '' : ' ') . convert_number($kn) . ' Thousand';
        }

        if ($Hn) {
            $res .= (empty($res) ? '' : ' ') . convert_number($Hn) . ' Hundred';
        }

        $ones = [
            '',
            'One',
            'Two',
            'Three',
            'Four',
            'Five',
            'Six',
            'Seven',
            'Eight',
            'Nine',
            'Ten',
            'Eleven',
            'Twelve',
            'Thirteen',
            'Fourteen',
            'Fifteen',
            'Sixteen',
            'Seventeen',
            'Eightteen',
            'Nineteen',
        ];
        $tens = ['', '', 'Twenty', 'Thirty', 'Fourty', 'Fifty', 'Sixty', 'Seventy', 'Eigthy', 'Ninety'];

        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= ' and ';
            }

            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];

                if ($n) {
                    $res .= '-' . $ones[$n];
                }
            }
        }

        if (empty($res)) {
            $res = 'zero';
        }

        return $res;
    }
@endphp
