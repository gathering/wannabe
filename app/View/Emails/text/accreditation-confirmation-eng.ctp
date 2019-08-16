Your application was registered and as been assigned the ID: <?=$accreditation['id']?>


Your application contains the following information:

Company name: <?=$accreditation['company_name']?>

Real name: <?=$accreditation['realname']?>

Phone number: <?=$accreditation['phonenumber']?>

E-mail: <?=$accreditation['email']?>

Number of persons: <?=$accreditation['numpersons']?>

Planned arrival date: <?=$accreditation['arrivaldate']['day']."/".$accreditation['arrivaldate']['month']."/".$accreditation['arrivaldate']['year']?>

Planned departure date: <?=$accreditation['departuredate']['day']."/".$accreditation['departuredate']['month']."/".$accreditation['departuredate']['year']?>


Permissions applied for:
Take pictures: <?=$accreditation['pictures']?"Yes":"No"?>

Take film: <?=$accreditation['film']?"Yes":"No"?>

Tour: <?=$accreditation['tour']?"Yes":"No"?>

SMS alert: <?=$accreditation['pictures']?"Yes":"No"?>


Extended info:
<?=$accreditation['extended_info']?>
