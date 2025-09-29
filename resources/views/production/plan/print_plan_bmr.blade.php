<html>
    <head>
        <title>{{$plan['plan_no']}}</title>
        <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;


            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 6cm;
                margin-left: 2cm;
                margin-right: 1.5cm;
                margin-bottom: 4.5cm;
                /*font-family: times new roman;*/
               
                font-family: sans-serif;
                font-size: 13px;
            }

            

            

                              
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
       @include('production.granulation.header')

       

      @include('production.granulation.footer')
        
        
       @include('production.dispensing.report')

       @include('production.granulation.report')

        @include('production.compression.report')
        
        @include('production.coating.report')

         @include('production.blistering.report')

                

         


           

        </main>


        
    </body>
</html>