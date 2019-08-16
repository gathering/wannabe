Your application was declined.

Your application contains the following information:

Company name: <?=$accreditation['Accreditation']['company_name']."\n"?>
Real name: <?=$accreditation['Accreditation']['realname']."\n"?>
Phone number: <?=$accreditation['Accreditation']['phonenumber']."\n"?>
E-mail: <?=$accreditation['Accreditation']['email']."\n"?>
Number of persons: <?=$accreditation['Accreditation']['numpersons']."\n"?>
Planned arrival date: <?=$accreditation['Accreditation']['arrivaldate']."\n"?>
Planned departure date: <?=$accreditation['Accreditation']['departuredate']."\n"?>

Permissions applied for:
Take pictures: <?=$accreditation['Accreditation']['pictures'] ? "Yes" : "No"?><?="\n"?>
Take film: <?=$accreditation['Accreditation']['film'] ? "Yes" : "No"?><?="\n"?>
Tour: <?=$accreditation['Accreditation']['tour'] ? "Yes" : "No"?><?="\n"?>
SMS alert: <?=$accreditation['Accreditation']['pictures'] ? "Yes" : "No"?><?="\n"?>

Extended info:
<?=$accreditation['Accreditation']['extended_info']."\n"?>

