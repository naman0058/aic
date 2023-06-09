<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body {
		  color: #717070;
		  padding-right: 30px;
		  padding-left: 30px;
		  font-size: 13px;
		  font-family: Arial, Helvetica, sans-serif;
		}

		
	</style>
	<style type="text/css" media="print">
        .breakclass
        {
            page-break-after: always;
        }
    </style>
</head>
<body>
   
<table width="100%" cellspacing="5px" cellpadding="5px;">
	<tr>
		<td colspan="4">
			<img src="{{ asset('public/images/logo.png') }}" width="200px;"> <br /><br />
			AI Company <br />
			AWFIS, 7th Floor, Ambience Mall, <br />
			Gurugram-122002, Haryana, India <br />
			Tel +91-9811059581, +91-8595417357 <br />
		</td>
	</tr>

	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" style="background-color: #7e97ad;height: 300px;color: white;font-size: 90px;margin-top: 360px;">FINAL <br /> INSPECTION <br /> REPORT</td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	
	<tr>
		<td>Inspection Date</td>
		<td>- {{date('d/m/ Y',strtotime($styleModel['InspectionDate']))}}</td>
		<td>Inspection No.</td>
		<td>- {{$styleModel['InspectionNo']}}</td>
	</tr>
	<tr>
		<td>Inspection Time </td>
		<td>- {{date('H:i',strtotime($styleModel['TimeIn']))}}</td>
		<td>Inspection Time Out</td>
		<td>- {{date('H:i',strtotime($styleModel['TimeOut']))}}</td>
	</tr>
	<tr>
		<td>Buyer</td>
		<td>- {{$styleModel['Buyer']}}</td>
		<td>Brand</td>
		<td>- {{$styleModel['Brand']}}</td>
	</tr>
	
</table>
<br />
<br />
<br />

<p style="page-break-after: always"></p>
<table width="100%" cellspacing="5px" cellpadding="5px;">
	<tr align="right">
		<td colspan="3" align="right">
			<img src="{{ asset('public/images/logo.png') }}" width="200px;">
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 25px;color:black;">Contents</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td style="margin-left: 25px;" width="300px;">
			Style Description (1/2)
		</td>
		<td width="200px;">----------------------------------------------</td>
		<td>1</td>
	</tr>

	<tr>
		<td width="300px;">Style Description (2/2) </td>
		<td width="200px;">----------------------------------------------</td>
		<td>2</td>
	</tr>

	<tr>
		<td width="300px300px;">Production Details </td>
		<td width="200px;">----------------------------------------------</td>
		<td>3</td>
	</tr>

	<tr>
		<td width="300px;">Observations </td>
		<td width="200px;">----------------------------------------------</td>
		<td>4</td>
	</tr>
	<tr>
		<td width="300px;">Remarks </td>
		<td width="200px;">----------------------------------------------</td>
		<td>6</td>
	</tr>

	<tr>
		<td width="300px;">QA Information</td>
		<td width="200px;">----------------------------------------------</td>
		<td>7</td>
	</tr>

	<tr>
		<td width="300px;">Company Information</td>
		<td width="200px;">----------------------------------------------</td>
		<td>8</td>
	</tr>

</table>
<p style="page-break-after: always"></p>
<table width="100%" cellspacing="5px" cellpadding="5px;">
	<tr align="right">
		<td colspan="3" align="right">
			<img src="{{ asset('public/images/logo.png') }}" width="230px;">
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 25px;color:black;">Style Description (1/2)</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td style="margin-left: 25px;">
			STYLE NO.
		</td>
		<td>:</td>
		<td>{{$styleModel['styleNo']}}</td>
	</tr>

	<tr>
		<td>PO NO.</td>
		<td>:</td>
		<td>{{$styleModel['PONo']}}</td>
	</tr>

	<tr>
		<td>VENDOR</td>
		<td>:</td>
		<td>{{$styleModel['Vendor']}}</td>
	</tr>

	<tr>
		<td>ORDER QTY. </td>
		<td>:</td>
		<td>{{$styleModel['OrderQty']}}</td>
	</tr>
	<tr>
		<td>FACTORY </td>
		<td>:</td>
		<td>{{$styleModel['Factory']}}</td>
	</tr>

	<tr>
		<td>SHIPPED QTY.</td>
		<td>:</td>
		<td>{{$styleModel['ShippedQty']}}</td>
	</tr>

	<tr>
		<td>DEL. DATE</td>
		<td>:</td>
		<td>{{date('d/m/Y',strtotime($styleModel['DelDate']))}}</td>
	</tr>

	<tr>
		<td>SHIPPED %</td>
		<td>:</td>
		<td>{{$styleModel['ShippedPercent']}}</td>
	</tr>

	<tr>
		<td>DIVISION</td>
		<td>:</td>
		<td>{{$styleModel['Division']}}</td>
	</tr>

	<tr>
		<td>GOLD SEAL/ PP</td>
		<td>:</td>
		<td>{{$styleModel['GoldSealPP']}}</td>
	</tr>

	<tr>
		<td>AQL</td>
		<td>:</td>
		<td>{{$styleModel['AQL']}}</td>
	</tr>

	<tr>
		<td>LEVEL</td>
		<td>:</td>
		<td>{{$styleModel['Level']}}</td>
	</tr>

</table>
<p style="page-break-after: always"></p>
<table width="100%" cellspacing="5px" cellpadding="5px;" >
	<tr align="right">
		<td align="right">
			<img src="{{ asset('public/images/logo.png') }}" width="200px;">
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 25px;color:black;">Style Description (2/2)</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

</table>
<table width="100%"  border="1" style="border-collapse:collapse">
	<tr>
		<th>Po#</th>
		<th>Order Qty.</th>
		<th>Colour</th>
		<!--<th>Stitch</th>-->
		<th>Pack</th>
		<th>AQL Sample Size</th>
	</tr>
	@php
	    $tqty=0;
	    $tpack=0;
	@endphp
	@foreach($styleModel['po_details'] as $PoDetail)
	@if($PoDetail['Po'] != '')
	<tr>
		<td>{{$PoDetail['Po']}}</td>
		<td>{{$PoDetail['OrderQty']}}</td>
		<td>{{$PoDetail['Colour']}}</td>
		{{-- <td>{{$PoDetail['Stitch']}}</td> --}}
		<td>{{$PoDetail['Pack']}}</td>
		<td>{{$PoDetail['AQLSampleSize']}}</td>
	</tr>
	@endif
	@php
	    if(is_numeric($PoDetail['OrderQty']))
	    {
	        $tqty+=$PoDetail['OrderQty'] ;
	    }
	    if(is_numeric($PoDetail['Pack']))
	    {
	        $tpack+=$PoDetail['Pack'] ;
	    }
	@endphp
    @endforeach()
	<tr>
		<td>TOTAL</td>
		<td align="center">{{$tqty}}</td>
		<td></td>
		<td align="center">{{$tpack != 0 ? $tpack : ''}}</td>
		<td></td>
		 
	</tr>

</table>
<p style="page-break-after: always"></p>
@foreach($styleModel['po_details'] as $PoDetail)
@if(isset($PoDetail['po_photo']) && $PoDetail['po_photo'] != ' ' && $PoDetail['po_photo'] != ''  )
<div align="left">
<table width="100%"  border="0" style="border-collapse:collapse">
    <tr align="right">
		<td align="right">
			<img src="{{ asset('public/images/logo.png') }}" width="200px;">
		</td>
	</tr>
	<tr>
		<td><h3>PO #{{$PoDetail['Po']}}</h3>&nbsp;</td>
	</tr>
	<tr style="height:250px;">
		<td><img src="{{ asset('public/uploads/po/compressed')}}/{{$PoDetail['po_photo']}}" height="250px;"></td>
	</tr>
</table>
</div>

<p style="page-break-after: always"></p>
@endif
@endforeach()
<table width="100%" cellspacing="5px" cellpadding="5px;">
	<tr align="right">
		<td colspan="3" align="right">
			<img src="{{ asset('public/images/logo.png') }}" width="200px;">
		</td>
	</tr>

	<tr>
		<td style="font-size: 25px;color:black;">Production Details</td>
	</tr>

	<tr>
		<td style="margin-left: 25px;">
			SHADE/ DYE LOTS
		</td>
		<td>:</td>
		<td>{{$styleModel['SHADE_DYELOTS']}}</td>
	</tr>

	<tr>
		<td>CONTENT LABEL</td>
		<td>:</td>
		<td>{{$styleModel['CONTENT_LABEL']}}</td>
	</tr>
    <tr>
		<td>GARMENT BALANCE</td>
		<td>:</td>
		<td>{{$styleModel['GARMENT_BALANCE']}}</td>
	</tr>
	<tr>
		<td>CARTON MARKING</td>
		<td>:</td>
		<td>{{$styleModel['CARTON_MARKING']}}</td>
	</tr>

	<tr>
		<td>RETAIL PRICE </td>
		<td>:</td>
		<td>{{$styleModel['RETAIL_PRICE']}}</td>
	</tr>
	<tr>
		<td>HAND FEEL</td>
		<td>:</td>
		<td>{{$styleModel['HAND_FEEL']}}</td>
	</tr>

	<tr>
		<td>EMBROIDERY</td>
		<td>:</td>
		<td>{{$styleModel['EMBROIDERY']}}</td>
	</tr>

	<tr>
		<td>IRON</td>
		<td>:</td>
		<td>{{$styleModel['IRON']}}</td>
	</tr>

	<tr>
		<td>WASH TEST</td>
		<td>:</td>
		<td>{{$styleModel['WASH_TEST']}}</td>
	</tr>

	<tr>
		<td>FOB</td>
		<td>:</td>
		<td>{{$styleModel['FOB']}}</td>
	</tr>

	<tr>
		<td>WASH ABRASION</td>
		<td>:</td>
		<td>{{$styleModel['WASH_ABRASION']}}</td>
	</tr>

	<tr>
		<td>PRINT</td>
		<td>:</td>
		<td>{{$styleModel['PRINT']}}</td>
	</tr>
    <tr>
		<td>FOLD</td>
		<td>:</td>
		<td>{{$styleModel['FOLD']}}</td>
	</tr>
	<tr>
		<td>SAMPLE</td>
		<td>:</td>
		<td>{{$styleModel['SAMPLE']}}</td>
	</tr>
    
	<tr>
		<td>ODOUR</td>
		<td>:</td>
		<td>{{$styleModel['ODOUR']}}</td>
	</tr>

	<tr>
		<td>SEQUINS/ H. WORK</td>
		<td>:</td>
		<td>{{$styleModel['SEQUINS_H_WORK']}}</td>
	</tr>
	<tr>
		<td>POLYBAG</td>
		<td>:</td>
		<td>{{$styleModel['POLYBAG']}}</td>
	</tr>

	<tr>
		<td>FPT/ GPT</td>
		<td>:</td>
		<td>{{$styleModel['FPT_GPT']}}</td>
	</tr>
	<tr>
		<td>SHIP MODE</td>
		<td>:</td>
		<td>{{$styleModel['SHIP_MODE']}}</td>
	</tr>

	<tr>
		<td>MAIN LABEL</td>
		<td>:</td>
		<td>{{$styleModel['MAIN_LABEL']}}</td>
	</tr>
	<tr>
		<td>BUTTON SIZE, COL.</td>
		<td>:</td>
		<td>{{$styleModel['BUTTON_SIZE_COL']}}</td>
	</tr>

	<tr>
		<td>TAGS/ EXTRA TRIMS</td>
		<td>:</td>
		<td>{{$styleModel['TAGS_EXTRA_TRIMS']}}</td>
	</tr>
	<tr>
		<td>SHIPMENT SAMPLE</td>
		<td>:</td>
		<td>{{$styleModel['SHIPMENT_SAMPLE']}}</td>
	</tr>

	<tr>
		<td>W/CARE</td>
		<td>:</td>
		<td>{{$styleModel['W_CARE']}}</td>
	</tr>
	<tr>
		<td>STITCH QUALITY</td>
		<td>:</td>
		<td>{{$styleModel['STITCH_QUALITY']}}</td>
	</tr>
	<tr>
		<td>PACKING</td>
		<td>:</td>
		<td>{{$styleModel['PACKING']}}</td>
	</tr>
</table>
<p style="page-break-after: always"></p>


@php
$dc=1;
@endphp
@foreach($styleModel['observation'] as $defects)
<table width="100%" cellspacing="5px" cellpadding="5px;">
	<tr align="right">
		<td align="right">
			<img src="{{ asset('public/images/logo.png') }}" width="200px;">
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 25px;color:black;">Observations</td>
	</tr>
	<tr>
		<td style="font-size: 25px;">Defect No.#{{$dc}}</td>
	</tr>
	
</table>
<div align="left"><h3>Description</h3></div>
<table width="100%"  border="1" style="border-collapse:collapse">
	<tr style="height: 150px;">
		<td>{{$defects['defects']}}</td>
	</tr>
</table>
@foreach($styleModel['colors'] as $color)
@if($defects['id'] == $color['defect_id'])
<div align="left"><h3>Major/Minor</h3></div>
<table width="100%" border="1" style="border-collapse:collapse">
	<tr style="height: 100px;">
		<td>Major :{{$color['major']}} <br> Minor : {{$color['minor']}} <br> Color : {{$color['color']}}</td>
	</tr>
</table>

<div align="left"><h3>Defect Photo</h3></div>
<table width="100%" border="0" style="border-collapse:collapse">
	<tr  >
		<td><img src="{{asset('public/uploads/defect/compressed')}}/{{$color['photo']}}" height="250px;"></td>
	</tr>
</table>
<p style="page-break-after: always"></p>
@endif
@endforeach()
@php
$dc++;
@endphp
@endforeach()
<table width="100%" cellspacing="5px" cellpadding="5px;">
	<tr align="right">
		<td align="right">
			<img src="{{ asset('public/images/logo.png') }}" width="200px;">
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	
</table>
<div align="left"><h3>Remark</h3></div>
<table width="100%"  border="1" style="border-collapse:collapse">
	<tr style="height: 150px;padding:20px;">
		<td>{{$styleModel['Remarks']}}</td>
	</tr>
</table>

<div align="left"><h3>Result</h3>
<h5>Pass/Fail/Hold for Approval</h5></div>
<table width="100%"  border="1" style="border-collapse:collapse">
	<tr style="height: 100px;">
		<td>{{ ucfirst($styleModel['finalResult']) }}</td>
	</tr>
</table>


<div align="left"><h3>Documents Attached</h3></div>
<table  width="100%"  border="1" style="border-collapse:collapse">
	<tr>
		<td>Factory Inspection Report/ Factory Measurement Report</td>
		<td>Yes / No / NA</td>
		<td>{{$styleModel['FactoryInspectionReport']}}</td>
	</tr>
	{{-- <tr>
		<td>Stock Inspection Report</td>
		<td>Yes / No / NA</td>
		<td>{{$styleModel['StockInspectionReport']}}</td>
	</tr>
	--}}
	<tr>
		<td>Button Pull Test Report</td>
		<td>Yes / No / NA</td>
		<td>{{$styleModel['BPTReport']}}</td>
	</tr>
	<tr>
		<td>Packing List/ Invoice</td>
		<td>Yes / No / NA</td>
		<td>{{$styleModel['PackingList']}}</td>
	</tr>
	<tr>
		<td>Metal Detection Report</td>
		<td>Yes / No / NA</td>
		<td>{{$styleModel['MetalDetectionReport']}}</td>
	</tr>
	<tr>
		<td>Others</td>
		<td>Yes / No / NA</td>
		<td>Others </td>
	</tr>
	
</table>
@if(isset($styleModel['trim']) && count($styleModel['trim']) != 0)
<div align="left"><h3>Trim Images</h3>
@for($i=0;$i < count($styleModel['trim']) ; $i++)
<table width="100%"  >
    
	<tr>
		<td><img src="{{asset('public/uploads/trim/compressed')}}/{{$styleModel['trim'][$i]['trim_image']}}" height="300px"></td>
		 
	</tr>

	 
</table>
@endfor
@endif


@if(isset($styleModel['packimages']) && count($styleModel['packimages']) != 0)
<div align="left"><h3>Pack Images</h3>
@for($i=0;$i < count($styleModel['packimages']) ; $i++)
<table width="100%"  >
    
	<tr>
		<td><img src="{{asset('public/uploads/packimage/compressed')}}/{{$styleModel['packimages'][$i]['packimage']}}" height="300px"></td>
		 
	</tr>

	 
</table>
@endfor
@endif
<p style="page-break-after: always"></p>
<table width="100%" cellspacing="5px" cellpadding="5px;">
	<tr align="right">
		<td align="right">
			<img src="{{ asset('public/images/logo.png') }}" width="200px">
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	
</table>
<div align="left"><h3>QA Information </h3>

<table width="100%" cellpadding="20px;" cellspacing="20px;">
	<tr>
		<td style="width: 48%;background-color: #7e97ad;color: white;"><b>FACTORY REPRESENTATIVE</b></td>
		<td style="width: 48%;background-color: #7e97ad;color: white;"><b>AIC QA</b></td>
	</tr>
	<tr>
		<td style="width: 48%;padding:0;margin:0;">
		    <img src="{{asset('public/uploads/fri/compressed')}}/{{$styleModel['factoryRepresentativeImage']}}"  width="100%" height="190px">
		</td>
		<td style="width: 48%;padding:0;margin:0;"><img src="{{asset('public/uploads/aqi/compressed')}}/{{$styleModel['aicQaImage']}}" width="100%" height="190px"></td>
	</tr>
	<tr>
	    <td>
	        {{ $styleModel['factoryrepname'] }}
	    </td>
	    <td>
	        
	        {{ $styleModel['aicmanagername'] }}
	    </td>
	</tr>
</table>
@if(isset($styleModel['additional_image']) && count($styleModel['additional_image']) != 0)
<p style="page-break-after: always"></p>
<table width="100%" cellspacing="5px" cellpadding="5px;">
	<tr align="right">
		<td align="right">
			<img src="{{ asset('public/images/logo.png') }}" width="200px;">
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	
</table>

<div align="left"><h3>Additional Photos/ Attachments</h3>
 
<table width="100%"  >
    @foreach($styleModel['additional_image'] as $add)
	<tr>
		<td><img src="{{asset('public/uploads/additional/compressed')}}/{{$add['additional_image']}}" height="300px;"></td>
		 
	</tr>
	@endforeach()
	 
</table>

@endif
<p style="page-break-after: always"></p>
<table width="100%" cellpadding="20px;" cellspacing="20px;">
    <tr align="right">
		<td align="right">
			<img src="{{ asset('public/images/logo.png') }}" width="200px;">
		</td>
	</tr>
	<tr>
		<td>
			<span style="text-align: justify;">Quality Inspections carried out by AI Company personnel are on a random basis and/ or any other inspection basis such as AQL inspection procedures etc. and are done to the best of their ability and knowledge. The result of these inspections, however, do not absolve the Manufacturer from their responsibility to conduct 100% Quality Inspections of the complete Merchandise & ALL Materials & Trims used and, based on the pre-production approvals and/ or the observations given by AI Company Staff, the Manufacturer's/ Factory's concerned staff MUST ensure that all approval standards and tolerance levels have been defined and that all technical specifications & other requirements are fully complied with and variations, if any, are within the approved tolerance levels. In case of any variations beyond/ not in accordance with the approved tolerances, the Manufacturer must segregate all such merchandise & take specific written approval before such merchandise can be packed.  <br /><br />
			In the event any clarification is required by the Manufacturer/ Factory, the same MUST be taken in writing only from the concerned AI Company staff & strictly adhered to by the Manufacturer/ Factory. <br /><br />
			It is expressly understood & agreed by the Manufacturer/ Shipper of the goods, that the complete responsibility in the event of any claims whatsoever and/ or ANY complaints from the Customer/ Buyer/ Consignee, who will exercise ultimate acceptance of goods, upon receipt at their destination, remains that of the Factory/ Supplier that manufactured, invoiced and/ or shipped the goods to the customer. <br />
		    </span>
		</td>
	</tr>
</table>
<p style="page-break-after: always"></p>
<table width="100%" cellspacing="5px" cellpadding="5px;">
	<tr align="right">
		<td align="right">
			<img src="{{ asset('public/images/logo.png') }}" width="200px;">
		</td>
	</tr>
	<tr>
		
		<td>
		    <div align="left"><h3>Company Information</h3></div>
			AI Company <br />
			AWFIS, 7th Floor, Ambience Mall, <br />
			Gurugram-122002, Haryana, India <br />
			Tel +91-9811059581, +91-8595417357 <br />
		</td>
	</tr>
</table>

</body>
</html>