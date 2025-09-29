<style type="text/css">
	 /*****PDF STYLE******/

  /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

           /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 5.2cm;
                margin-left: 0.3cm;
                margin-right: 0.3cm;
                margin-bottom: 2.2cm;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 14px;
            }

            
            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 5.2cm;
                 padding-left: 15px;
                  font-size:16px;

                /** Extra personal styles **/
                /*background-color: #03a9f4;*/
                /*color: white;*/
                /*text-align: center;*/
                /*line-height: 1.5cm;*/
            }
            header p{
             margin-bottom: 5px;
             margin-top: 5px;
            }

           /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2.2cm;

                /** Extra personal styles **/
                /*background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 1.5cm;*/
                    }
.top-heading{ 
                        font-size: 20px;
                         font-weight:bold;
                         text-transform: uppercase;
                          }

                    .top-heading-name{ font-size: 12px; text-transform: uppercase; }

                    .top-heading-address{ text-align: left; }

                    .challan-detail td,.challan-detail th{

                      text-align: left;
                      padding-left: 15px;
                    }
             
                    .page_num:after { content: counter(page); }

            .pages:after { content:  counter(pages); }

            .item-table{
             
            width: 100%;
             }

             .item-table td,.item-table th{
             
                border: 1px solid black;
             }
            .col{
             
            padding: 3px;
            text-align: center;
             }

             .bottom{
                border-bottom: 1px dotted black;
             }

             .col1{
             
            padding: 4px;
            text-align: center;
             }

             .item-name-th{

                width: 40% ;
                text-align: left;
                padding-left: 7%;
             }

             .item-name-col{

                width: 40% ;
                text-align: left;
             }

             .sign{
              
              border-top: 1px solid black !important;
              
              padding : 15px ;

            }
            .sign-box{
    border-spacing:50px 0px;
     width: 100%;
     margin-top: 50px;
   }
   .sign-box th{
      padding:5px 0px;
      width: 25%;
   }
             .sign{
              
              border-top: 1px solid black !important;
              
              padding : 10px ;

            }

            .sign span{
                          }
             .from , .to{
                
                border:1px solid black;
                 width: 40%;
                  font-size: 12px;
                height: 100px;
                padding-left: 5 ;
                padding-right: 5;

             }
             .name{
                text-transform: uppercase;
             }
             .address{
                 text-align: center;
             }

             .ctble{
    width: 100%;
    margin: 0px;
}
.ctble td:nth-child(1){
    width: 60%;
}
.ctble td:nth-child(2){
    width: 60%;
}




</style>