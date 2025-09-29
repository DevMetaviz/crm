
<script type="text/php">
    if (isset($pdf)) {
    echo $PAGE_COUNT;
        $x =  $pdf->get_width() - 90;
        $y =  $pdf->get_height() - 40;
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);


    }
</script>

<style type="text/css">

    /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 4cm;

                padding-left: 50px ;
                padding-right: 38px;

                
                font-weight: bold;
                font-size: 10px;

                /** Extra personal styles **/
                /*background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 1.5cm;*/
                    }


    #head_top_table{
                      width: 100%;
                      border: 1px solid black;
                      text-transform: uppercase;
                 } 

                  #head_top_table tr{
                      width: 100%;
                 }  

                 #head_top_table tr td{
                 width: 25%;
                 border: 1px solid black;
                 text-align: center;
                 }

                 #sign_row td{
                  padding-top: 10px;
                  padding-bottom: 10px;
                 }
</style>
<footer style="border: 0px solid red;">

          <table class="" id="head_top_table" style="">

                <tr style="background-color:#bfbfbf;">
                    <td></td>
                    <td colspan="2">Prepared By:</td>
                    <td colspan="3">Reviewed By:</td>
                    <td>Approved By:</td>
                </tr>

                <tr>
                    <td>DESIGNATION</td>
                    <td>PRODUCTION PHARMACIST</td>
                    <td>QA OFFICER</td>
                    <td>QC MANAGER</td>
                    <td>PRODUCTION MANAGER</td>
                    <td>QA MANAGER</td>
                    <td>PLANT MANAGER</td>
                </tr>
                <tr id="sign_row">
                    <td>SIGN & DATE</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                
            </table>
            <p style="font-size: 16px;"><center><b><i>“Controlled Document”</i></b></center></p>
    
       </footer>