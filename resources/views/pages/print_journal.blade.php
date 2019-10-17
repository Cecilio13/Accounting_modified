@extends('layout.no_side_navs')


@section('content')
<table id="jounalentrytable" class="table table-bordered table-responsive-md table-striped  font14" width="100%">
        <thead>
            <tr>
                <th width="8%" class="text-center">JOURNAL DATE</th>
                <th width="5%" class="text-center">ACCOUNT CODE</th>
                <th width="5%" class="text-center">JOURNAL NO</th>
                <th width="20%" class="text-center">ACCOUNT</th>
                <th class="text-center">DEBIT</th>
                <th class="text-center">CREDIT</th>
                <th class="text-center">DESCRIPTION</th>
                <th class="text-center">NAME</th>
                
            </tr>
        </thead>
        <tbody>
            @if(count($JournalEntry)>0)
            @foreach($JournalEntry as $je)
                @if ($Journal_no_selected==$je->je_no)
                    <tr>
                        <td style="vertical-align:middle;text-align:center;">{{date("m-d-Y", strtotime($je->created_at))}} </td>
                        <td style="vertical-align:middle;text-align:center;">
                            @foreach ($COA as $coa)
                                @if($coa->id==$je->je_account)
                                @if(!empty($numbering) && $numbering->use_cost_center=="Off")
                                {{$coa->coa_code}}
                                @else
                                @if($je->je_cost_center!="")
                                <?php
                                $cost_center_code="";
        
                                ?>
                                @foreach ($cost_center_list as $list)
                                    @if($list->cc_no==$je->je_cost_center)
                                    <?php
                                    $cost_center_code=$list->cc_name_code;
                                    ?>
                                    @endif
                                @endforeach
                                {{$cost_center_code."-".$coa->coa_code}}
                                @else 
                                {{$coa->coa_code}}
                                @endif
                                @endif
                                
                                @endif
                            @endforeach    
                            
                        
                        </td>
                        <td style="vertical-align:middle;text-align:center;">{{$je->je_no}}</td>
                        <?php
                        $journalaccount="";
                        ?>
                        @foreach ($COA as $coa)
                            @if($coa->id==$je->je_account)
                            <?php
                            $journalaccount=$coa->coa_name;
        
                            ?>
                            @endif
                        @endforeach
                        <td style="vertical-align:middle;{{$je->je_debit!=""? "text-align:left;": "text-align:left;padding-left:20px;"}}">{{is_numeric($je->je_account)==true? $journalaccount : $je->je_account}}</td>
                        <td style="vertical-align:middle;">{{$je->je_debit!=""? number_format($je->je_debit,2): ""}}</td>
                        <td style="vertical-align:middle;">{{$je->je_credit!=""? number_format($je->je_credit,2) : ""}}</td>
                        <td style="vertical-align:middle;">{{$je->je_desc}}</td>
                        <td style="vertical-align:middle;">
                            {{$je->je_name}}
                            
                        </td>
                        
                        </tr>  
                @endif
                
            @endforeach
            @endif

            
        </tbody>
            <!-- This is our clonable table line -->
    </table>
<script>
$(document).ready(function(){
    window.print();
    window.close();
})
</script>
@endsection