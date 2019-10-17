<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{$value[0]['title']}}</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: small;
    }
    .gray {
        background-color: lightgray
    }
</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td valign="top"><h2>{{$value[0]['title']}}</h2></td>
        <td align="right">
            <?php
            if($company!=""){

            
            ?>
            <h3>{{$company!=""? $company->company_name: '' }}</h3>
            <pre>
                {{$company!=""? $company->company_name: '' }}<br>
                {{$company!=""? $company->company_address.", ".$company->company_address_postal : ''}}<br>
                {{$company!=""? $company->company_phone: ''}}<br>
                {{$company!=""? $company->company_email : ''}}<br>
                
            </pre>
            <?php
            }
            ?>
        </td>
    </tr>

  </table>

  <table width="100%">
    <tr>
        <td><strong>From: </strong>{{$company!=""? $company->company_name: '' }}</td>
        <td><strong>To: </strong>{{$value[0]['name']}}</td>
    </tr>

  </table>

  <br/>

  <table width="100%">
        <thead style="background-color: lightgray;">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
            <?php
            $key=0;
            ?>
        @foreach ($value as $datum)
            <tr>
                <th scope="row">{{ $key+1 }}</th>
                <td scope="row">{{$datum['product_name']}}</td>
                <td>{{$datum['product_description']}}</td>
                <td align="right">{{$datum['product_quantity']}}</td>
                <td align="right"><span style='font-family: DejaVu Sans; sans-serif;'>&#8369;</span> {{number_format($datum['product_rate'],2)}}</td>
                <td align="right"><span style='font-family: DejaVu Sans; sans-serif;'>&#8369;</span> {{number_format($datum['product_total'],2)}}</td>
            </tr>
        @endforeach
          
        </tbody>
    
        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td align="right">Total</td>
                <td align="right" class="gray"><span style='font-family: DejaVu Sans; sans-serif;'>&#8369;</span> {{number_format($value[0]['credit_total'],2)}}</td>
            </tr>
        </tfoot>
    </table>


</body>


</html>