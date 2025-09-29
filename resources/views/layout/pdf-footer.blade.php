 <script type="text/php">
    if (isset($pdf)) {
    echo $PAGE_COUNT;
        $x =  $pdf->get_width() - 90;
        $y =  $pdf->get_height() - 50;
        $text = "page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);


    }
</script>

        <footer style="">
    <div>
        <!-- <p>Page <span class="page_num"></span> of <span class="pages"></span> -->
            <p style="margin-bottom:5px"><span style="margin-left:60px;">{{date('d-M-Y')}}</span><span style="margin-left:30px;">{{date('H:i:s A')}}</span></p>
    </div>
    <div style="height:30px;background-color: #03a9f4;margin-bottom: ;"></div>
  </footer>


  