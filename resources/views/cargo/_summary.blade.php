<table class="table">
    @php
    $rate=1230;
    $subTotalInTZS= $sum*$rate;
    $VAT= 15/100*$subTotalInTZS;
    $grandTotal= $subTotalInTZS+$VAT;
    @endphp
    <tr style="background-color: white;">
        <td>USD Exchange Rate</td>
        <td>{{number_format($rate)}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr style="background-color: white;">
        <td>Subtotal (USD)</td>
        <td>{{number_format($sum)}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr style="background-color: white;">
        <td>Subtotal (TZS)</td>
        <td>{{number_format($subTotalInTZS)}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr style="background-color: white;">
        <td>VAT (TZS)</td>
        <td>{{number_format($VAT)}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr style="background-color: white;">
        <td>Grand Total (TZS)</td>
        <td>{{number_format($grandTotal)}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>