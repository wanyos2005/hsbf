<div class="padding-10">

    <br>

    <div class="pull-left">
        

        <address>

            <br>

            <strong>x County.</strong>

           
        </address>

    </div>

    <div class="pull-right well well-sm  bg-color-darken txt-color-white no-border">

        <h1 class="font-400 ">Business Permit Bill</h1>

    </div>

    <div class="clearfix"></div>

    <br>

    <br>

    <div class="row">

        <div class="col-sm-9">

            <?=$bill[0]->business['business_name']?><br/>
            P.O BOX <?=$bill[0]->business['bs_box_no']?> - <?=$bill[0]->business['bs_postal_code']?> 

        </div>

        <div class="col-sm-3">

            <div>

                <div>

                    <strong>BILL NO :</strong>

                    <span class="pull-right"> #12344 </span>

                </div>



            </div>

            <div>

                <div class="font-md">

                    <strong>BILL DATE :</strong>

                    <span class="pull-right"> <i class="fa fa-calendar"></i> 

2011-12-2013 </span>

                </div>



            </div>

            <br>

            <div class="well well-sm  bg-color-darken txt-color-white no-border">

                <div class="fa-lg">

                    Total Due :

                    <span class="pull-right">KSH 60000</span>

                </div>



            </div>

            <br>

            <br>

        </div>

    </div>

    <table class="table table-hover">

        <thead>

            <tr>

                <th class="text-center">QTY</th>

                <th>ITEM</th>

                <th>DESCRIPTION</th>

                <th></th>

                <th>SUBTOTAL</th>

            </tr>

        </thead>

        <tbody>

            <?php $bill_total=0; foreach($bill_items as $bill_item):?>
            <tr>

                <td class="text-center"><strong>1</strong></td>

                <td><a href="javascript:void(0);"><?=$bill_item['bill_item']?></a></td>

                <td><?=$bill_item['bill_item_description']?></td>

                <td></td>



                <td><?=$bill_item['bill_item_amount']?></td>

            </tr>
            <?php  $bill_total+=$bill_item['bill_item_amount']; endforeach;?>
         
            <tr>

                <td colspan="4">Total</td>

                <td><strong>KSH <?=$bill_total;?></strong></td>

            </tr>

            

        </tbody>

    </table>



    <div class="invoice-footer">



        <div class="row">



            <div class="col-sm-7">

<!--                <div class="payment-methods">

                    <h5>Payment Methods</h5>

                    <img src="img/invoice/paypal.png" width="64" height="64" alt="paypal">

                    <img src="img/invoice/americanexpress.png" width="64" height="64" alt="american express">

                    <img src="img/invoice/mastercard.png" width="64" height="64" alt="mastercard">

                    <img src="img/invoice/visa.png" width="64" height="64" alt="visa">

                </div>-->

            </div>

            <div class="col-sm-5">

                <div class="invoice-sum-total pull-right">

                    <h3><strong>Total: <span class="text-success">KSH <?=$bill_total;?></span></strong></h3>

                </div>

            </div>



        </div>



        <div class="row">

            <div class="col-sm-12">

                <p class="note">**To avoid any excess panelty charges, please make payments within 30 days of the bill date. There will be a 2% interest charge per month on all late payments.</p>

            </div>

        </div>

				

    </div>

</div>
