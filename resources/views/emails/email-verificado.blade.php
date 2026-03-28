<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Tu cuenta está lista! — Sofis Tienda de Modas</title>
</head>
<body style="margin:0; padding:0; background-color:#F6F4F1; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#F6F4F1; padding:40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="max-width:560px; background-color:#ffffff;
                           border:1px solid #E2DED9; border-radius:16px; overflow:hidden;">

                    {{-- Cabecera con marca --}}
                    <tr>
                        <td align="center"
                            style="background-color:#1A1A18; padding:32px 40px;">
                            <p style="margin:0; color:#F6F4F1;
                                      font-size:22px; font-weight:600; letter-spacing:0.05em;">
                                ✦ Sofis Tienda de Modas
                            </p>
                        </td>
                    </tr>

                    {{-- Cuerpo --}}
                    <tr>
                        <td style="padding:40px 40px 32px;">

                            <h1 style="margin:0 0 8px; font-size:24px; font-weight:700;
                                       color:#1A1A18; line-height:1.3;">
                                ¡Tu cuenta está verificada! 🎉
                            </h1>

                            <p style="margin:0 0 24px; font-size:15px; color:#716F6A; line-height:1.6;">
                                Hola, <strong style="color:#1A1A18;">{{ $user->name }}</strong>.
                                Tu correo electrónico ha sido verificado exitosamente.
                                Ya puedes disfrutar de todos los beneficios de tu cuenta.
                            </p>

                            {{-- Divisor --}}
                            <hr style="border:none; border-top:1px solid #E2DED9; margin:0 0 24px;">

                            <p style="margin:0 0 8px; font-size:13px; font-weight:600;
                                      letter-spacing:0.12em; text-transform:uppercase; color:#716F6A;">
                                ¿Qué puedes hacer ahora?
                            </p>

                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding:10px 0; border-bottom:1px solid #F6F4F1;">
                                        <span style="color:#9B1D3A; font-size:15px; margin-right:10px;">✦</span>
                                        <span style="font-size:14px; color:#1A1A18;">Explorar las últimas colecciones</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0; border-bottom:1px solid #F6F4F1;">
                                        <span style="color:#9B1D3A; font-size:15px; margin-right:10px;">✦</span>
                                        <span style="font-size:14px; color:#1A1A18;">Guardar tus prendas favoritas</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0;">
                                        <span style="color:#9B1D3A; font-size:15px; margin-right:10px;">✦</span>
                                        <span style="font-size:14px; color:#1A1A18;">Descubrir ofertas exclusivas</span>
                                    </td>
                                </tr>
                            </table>

                            {{-- Botón CTA --}}
                            <div style="margin-top:32px; text-align:center;">
                                <a href="{{ route('catalogo') }}"
                                    style="display:inline-block; background-color:#1A1A18; color:#F6F4F1;
                                           text-decoration:none; font-size:14px; font-weight:600;
                                           padding:14px 36px; border-radius:10px;
                                           letter-spacing:0.04em;">
                                    Ir al catálogo
                                </a>
                            </div>

                        </td>
                    </tr>

                    {{-- Pie --}}
                    <tr>
                        <td style="background-color:#F6F4F1; padding:24px 40px;
                                   border-top:1px solid #E2DED9; text-align:center;">
                            <p style="margin:0; font-size:12px; color:#716F6A; line-height:1.6;">
                                Recibiste este correo porque creaste una cuenta en
                                <strong>Sofis Tienda de Modas</strong>.<br>
                                Si no fuiste tú, puedes ignorar este mensaje.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
