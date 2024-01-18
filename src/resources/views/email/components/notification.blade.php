<tr>
    <td style="direction:ltr;font-size:0px;padding:0 20px;text-align:center;">
        <div style="background:{{ $background }};background-color:{{ $background }};margin:0px auto;border-radius:4px;max-width:560px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:{{ $background }};background-color:{{ $background }};width:100%;border-radius:4px;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:5px;text-align:center;">
                            <!--[if mso | IE]>
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                
                    
        <tr>
      
            <td
               class="" style="vertical-align:top;width:550px;"
            >
          <![endif]-->
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                                    <tbody>
                                        <tr>
                                            <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                <div
                                                    style="font-family:Roboto, Helvetica, Arial, sans-serif;font-size:24px;font-weight:400;line-height:30px;text-align:left;color:{{ $text_color }};">
                                                    @if ($type)
                                                        <p class="date" style="margin: 0; margin-bottom: 5px; font-size: 16px; text-transform: uppercase; font-weight: 600">{{ $type }}
                                                        </p>
                                                    @endif
                                                    <h2 style="margin: 0; font-size: 20px; font-weight: 300; line-height: 24px;">
                                                        {{ $title }}
                                                    </h2>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                <div
                                                    style="font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;font-weight:400;line-height:20px;text-align:left;color:{{ $text_color }};">
                                                    <p style="margin: 0;">
                                                        {{ $message }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                        @if ($button_href)
                                            <tr>
                                                <td align="right" vertical-align="middle"
                                                    style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                        style="border-collapse:separate;line-height:100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" bgcolor="{{ $text_color }}" role="presentation"
                                                                    style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px;background:{{ $text_color }};"
                                                                    valign="middle">
                                                                    <a target="_blank" rel="noopener noreferrer" href="{{ $button_href }}"
                                                                        style="display: inline-block; background: {{ $text_color }}; color: {{ $background }}; font-family: Roboto, Helvetica, Arial, sans-serif; font-size: 13px; font-weight: normal; line-height: 120%; margin: 0; text-decoration: none; text-transform: none; padding: 10px 25px; mso-padding-alt: 0px; border-radius: 3px;">
                                                                        <strong>{{ $button_text }}</strong>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!--[if mso | IE]>
            </td>
          
        </tr>
      
                  </table>
                <![endif]-->
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </td>
</tr>
<tr>
    <td style="direction:ltr;font-size:0px;padding:0;text-align:center;">
        <!--[if mso | IE]>
<table role="presentation" border="0" cellpadding="0" cellspacing="0">

<tr>

<td
class="" style="vertical-align:top;width:560px;"
>
<![endif]-->
        <div class="mj-column-per-100 mj-outlook-group-fix"
            style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                <tbody>
                    <tr>
                        <td style="font-size:0px;word-break:break-word;">
                            <!--[if mso | IE]>

<table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td height="20" style="vertical-align:top;height:20px;">

<![endif]-->
                            <div style="height:20px;"> &nbsp; </div>
                            <!--[if mso | IE]>

</td></tr></table>

<![endif]-->
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--[if mso | IE]>
</td>

</tr>

</table>
<![endif]-->
    </td>
</tr>
