<table width="45%" border="0" align="center" cellpadding="0" cellspacing="0" class="mt-5" style="
background: #f9f8f8;
border: 1px solid #e5e5e5;
margin: auto;
padding: 0 14px 20px 14px;
text-align: center;
margin: 50px auto;
">
<tbody>
<tr>
<td><img src="{{URL::asset('assets/front/images/confirmed-icon.png')}}" alt="" style="margin-top: -30px;"></td>
</tr>
<tr style="height: 60px;">
<td><span style="
font-size: 20px;
font-family: arial;
margin: 12px;
color: #ffffff;
font-weight: bold;
background: #46b04b;
padding: 6px 15px;
border-radius: 5px;
">Registration completed successfully
</span></td>
</tr>
<tr>
<td height="5" align="center"></td>
</tr>
<tr>
<td align="center"></td>
</tr>

<tr>
<td align="center"><span style="
font-size: 14px;
font-family: arial;
margin-bottom: 12px;
color: #000000;
padding: 20px;">Hello  <b>{{$name}} </b></span></td>
</tr>

<tr>
<td align="center"><span style="
font-size: 14px;
font-family: arial;
margin-bottom: 12px;
color: #000000;
padding: 20px;">Congratulations on creating your new account.</span></td>
</tr>

<tr>
<td align="center"><span style="
font-size: 14px;
font-family: arial;
margin-bottom: 12px;
color: #000000;
padding: 20px;">You’re just one click away from getting started with website. All you need to do is verify your email address to activate your account</span></td>
</tr>


<tr style="height: 60px;">
            <td align="center"><a href="{{url('verify-user?token='.$token)}}" style="
background: #000;
padding: 10px 30px;
color: #fff;
font-size: 14px;
box-shadow: none;
text-align: center;
margin-left: 8px;
text-decoration: none;
font-family: Arial, Helvetica, sans-serif;
">Click here</a></td>
        </tr>
<tr>
<td align="center" style="
font-size: 14px;
font-family: arial;
margin-bottom: 12px;
color: #000000;
padding: 18px;

">&nbsp;</td>
</tr>
</tbody>
</table>