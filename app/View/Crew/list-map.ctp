<script type="text/javascript">
    infowindow = new Array, marker = new Array;
    function placeMarker(user_id,image,profile,name,nick,crew,lat,lng) {
        if(image) {
            infowindow[user_id] = new google.maps.InfoWindow({
                content: '<span><strong><img src="http://wannabe.gathering.org/'+image+'_50.png" style="float:left; margin-right: 10px;" /><a href="'+profile+'">'+name+' aka '+nick+'</a></strong><br />'+crew+'</span>'
            });
        } else {
            infowindow[user_id] = new google.maps.InfoWindow({
                content: '<span><strong><a href="'+profile+'">'+name+' aka '+nick+'</a></strong><br />'+crew+'</span>'
            });
        }
        marker[user_id] = new google.maps.Marker({
            position: new google.maps.LatLng(lat,lng),
            map: map,
            title: name+' aka '+nick
        });
        google.maps.event.addListener(marker[user_id], 'click', function() {
            infowindow[user_id].open(map,marker[user_id]);
        });
    }
    function initGoogleMapsAPI() {
        <?php if($geocode->userNeedGeocodeUpdate): ?>
            geocoder = new google.maps.Geocoder();
        <? endif; ?>
        var eventLatLng = new google.maps.LatLng(<?=$wannabe->event->latitude?>, <?=$wannabe->event->longitude?>);
        var mapOptions = {
            zoom: 5,
            center: eventLatLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        var image = '/img/flag.png';
        var eventMarker = new google.maps.Marker({
            position: eventLatLng,
            map: map,
            icon: image,
            title: "<?=$wannabe->event->name?>"
        });
        eventInfowindow = new google.maps.InfoWindow({
            content: '<span><strong><?=$wannabe->event->name?></strong></span>'
        });
        google.maps.event.addListener(eventMarker, 'click', function() {
            eventInfowindow.open(map,eventMarker);
        });
        <?php foreach($crews as $crew) foreach($members[$crew['Crew']['id']] as $member) {
            if($member['UserPrivacy']['address']) continue;

            if($member['User']['id'] == $wannabe->user['User']['id'] && $geocode->userNeedGeocodeUpdate) { ?>
                var address = "<?=$geocode->userAddress?>";
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var latlng = results[0].geometry.location;
                        var post = $.post("<?=$this->Wb->eventUrl('/Geocode')?>", {
                            address: "<?=$geocode->userAddress?>",
                            latitude: latlng.lat(),
                            longitude: latlng.lng(),
                            user_id: <?=$wannabe->user['User']['id']?>,
                        })
                        .success(function(data) {
                            data = $.parseJSON(data);
                            if(data.success) {
                                placeMarker(
                                    "<?=$wannabe->user['User']['id']?>",
                                    "<?=$wannabe->user['User']['image']?>",
                                    "<?=$this->Wb->eventUrl('/Profile/View/'.$wannabe->user['User']['id'])?>",
                                    "<?=h($wannabe->user['User']['realname'])?>",
                                    "<?=h($wannabe->user['User']['nickname'])?>",
                                    "<?=h($wannabe->user['Crew'][0]['name'])?>",
                                    latlng.lat(),
                                    latlng.lng()
                                );
                            } else {
                                showAlert("Error saving geocode to cache", '<a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>');
                            }
                        })
                        .error(function() {
                            showAlert("Error saving geocode to cache", '<a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>');
                        })
                    } else {
                        if(status == 'ZERO_RESULTS') {
                            var post = $.post("<?=$this->Wb->eventUrl('/Geocode/invalidate')?>", {
                                address: "<?=$geocode->userAddress?>"
                            })
                            .success(function(data) {
                                data = $.parseJSON(data);
                                if(data.success) {
                                    showAlert(
                                        '<?=__("Your address did not match any geograpical coordinates, which probably means your address is invalid. You might want to update your address!")?>',
                                        '<a class="btn small" href="<?=$this->Wb->eventUrl('/Profile/Edit')?>"><?=__("Edit your profile")?></a> <a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>'
                                    );
                                }
                            })
                            .error(function() {
                                showAlert("Error saving geocode to cache", '<a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>');
                            })

                        } else {
                            showAlert("Geocode was not successful for the following reason: " + status, '<a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>');
                        }
                    }
                });
            <? } else {
                $address = $member['User']['address']." ".$member['User']['postcode']." ".$member['User']['town'];
                foreach($geocode->cache as $geo) if($geo['Geocode']['address'] == $address) {
                    if($geo['Geocode']['invalid']) {
                        if($member['User']['id'] == $wannabe->user['User']['id'] && !$geocode->userNeedGeocodeUpdate) { ?>
                            showAlert(
                                '<?=__("Your address did not match any geograpical coordinates, which probably means your address is invalid. You might want to update your address!")?>',
                                '<a class="btn small" href="<?=$this->Wb->eventUrl('/Profile/Edit')?>"><?=__("Edit your profile")?></a> <a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>'
                            );
                        <? } ?>
                    <? } elseif($canViewDetailedInfo || (isset($member['UserPrivacy']['phone']) && !$member['UserPrivacy']['phone'])) { ?>
                        placeMarker(
                            "<?=$member['User']['id']?>",
                            "<?=$member['User']['image']?>",
                            "<?=$this->Wb->eventUrl('/Profile/View/'.$member['User']['id'])?>",
                            "<?=h($member['User']['realname'])?>",
                            "<?=h($member['User']['nickname'])?>",
                            "<?=h($member['Crew']['name'])?>",
                            "<?=$geo['Geocode']['latitude']?>",
                            "<?=$geo['Geocode']['longitude']?>"
                        );
                    <? } ?>
                <? } ?>
            <? } ?>
        <? } ?>
    }

    function loadGoogleMapsAPI() {
        var s=document.createElement("script");
        s.type="text/javascript";
        s.src="https://maps.googleapis.com/maps/api/js?key=<?=$geocode->apikey?>&sensor=false&callback=initGoogleMapsAPI";
        document.body.appendChild(s);
    }
    window.onload = loadGoogleMapsAPI;
</script>
<div style="height: 20px; margin-top: 60px; margin-left: 10px; position: absolute; z-index: 2000;"><a href="<?=$this->Wb->eventUrl('/Crew?extended=0')?>" class="btn btn-default"><?=__("Normal")?></a></div>
<div id="map_canvas" style="width: 100%; height: 100%"></div>
