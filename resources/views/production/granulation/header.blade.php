 <style type="text/css">
     
     /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 4.7cm;

                padding-top: 30px;
                padding-left: 50px ;
                padding-right: 38px;
                text-transform: uppercase; 
                font-family: times new roman;
                /** Extra personal styles **/
                /*background-color: #03a9f4;*/
                /*color: white;*/
                /*text-align: center;*/
                /*line-height: 1.5cm;*/
            }

             #head_table{
                      width: 100%;
                      border: 3px ridge black;
                 }

                 #head_table tr td{
                      width: 100%;
                      border: 1px ridge black;
                      padding: 4px 5px;
                 }
                    
 </style>
 <header>

            
          <div style="border: 1px solid black;padding:3px; ">
            <table class="" id="head_table" style="" cellspacing ="2">

                <tr style="border-bottom: 3px solid black;">
                    <td rowspan="2" style="width: 20%"><img src="{{url('public/images/logo.jpg')}}" height="60" width="170"></td>
                    <td colspan="2" style="width: 80%"><center>FAHMIR PHARMA (PVT) LTD</center></td>
                   
                </tr>

                <tr>
                    
                    <td colspan="2" style="width: 80%"><center>BATCH MANUFACTURING RECORD</center></td>
                    
                </tr>

                <tr>
                    <td rowspan="2" style="width: 30%">PRODUCT NAME:<br>{{$plan['product']['item_name']}}</td>
                    <td style="width: 40%">BATCH SIZE :{{$plan['batch_size'].' TABLETS'}}</td>
                    <td style="width: 30%">BATCH NO :{{$plan['batch_no']}}</td>
                </tr>

                <tr>
                    <td style="width: 40%">DOCUMENT NO :</td>
                    <td style="width: 30%">REVISION NO :</td>
                </tr>

                <tr>
                    <td>MFG. DATE :{{$plan['mfg_date']}}</td>
                     <td>EXP. DATE :{{$plan['exp_date']}}</td>
                    <td>PACK SIZE :{{$plan['product']['pack_size']}}</td>
                </tr>
                
                
            </table>
            </div>
               
        </header>