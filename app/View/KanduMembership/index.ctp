<?php if(isset($disabled)): ?>
<p>Det er dessverre ikke mulig å velge Kandu medlemskap akkurat nå. Dersom du har spørsmål kan KANDU kontaktes på kontoret@kandu.no</p>
    <p><a href="/">Gå tilbake til fremsiden</a></p>

<?php elseif(isset($expired) and isset($done) == false): ?>
    <p>Fristen for å melde seg inn via Wannabe har nå gått ut. For innmelding brukes det vanlige skjemaet på kandu.no. Dersom du har spørsmål kan KANDU kontaktes på kontoret@kandu.no</p>
    <?php if(isset($done)):
        $action = $done['KanduMembership']['choice'];
        if($action == 0): ?>
            <h4>Du har valgt: Ønsker ikke medlemskap i KANDU for <?=$year?></h4>
            <p>NB! Merk at du ikke vil få tilsendt informasjon om aktivitetstilbud utenom det som sendes på crewlista.</p>
        <?php elseif($action == 1): ?>
            <h4>Du har valgt: Ønsker gratis medlemskap i KANDU for <?=$year?></h4>
            <?php if($age < 26): ?>
                <p>NB! Du er under 26 år, og kan generere statsstøtte som brukes til aktiviteter! Vi setter pris på om du vurderer betalt medlemskap for 50kr, valget nedenfor. Du står naturligvis helt fritt til å velge gratis medlemskap dersom du heller ønsker det.</p>
            <?php endif; ?>
        <?php elseif($action == 2): ?>
            <h4>Du har valgt: Ønsker betalt medlemskap i KANDU (støttegenererende, 50kr)</h4>
            <p>Takk for at du vil støtte KANDU! Du kan betale inn kontingenten på 50kr til konto 5081.05.36974. Merk betalinga med navnet ditt.</p>
        <?php endif; // $action == 0 ?>
        <?php if($action > 0): ?>
            <p>Informasjon om ditt valg samt personalia er oversendt KANDU.</p>
        <?php endif; // $action > 0 ?>
    <?php endif; // isset($done) ?>
<?php else: ?>
    <?php if(!isset($done)): ?>
    <form method="post">
    <fieldset>
        <div class="clearfix">
            <div class="input">
                <h3>KANDU-medlemskap</h3>
                <p>Siden 1996 har KANDU vært ansvarlig for arrangeringa av The Gathering,
                og siden da har deltakere blitt medlem av organisasjonen.
                Nå får også crewmedlemmer muligheten til å bli medlem i KANDU. Som
                medlem har du fulle demokratiske rettigheter, inkludert rett (men ikke
                plikt) til å delta på årsmøtet, stille til valg og mer.</p>

                <p>Som medlem i organisasjonen kan du også nyte godt av de medlemstilbudene
                som finnes. KANDU har arrangementlokaler i Oslo som kan benyttes av
                medlemmer, både i forbindelse med KANDU-arrangementer som spillkvelder,
                kurs og lignende samt for utlån. Vi har et til to arrangement hver
                måned, og om du vil skape noe der du bor er vi veldig åpen for det.</p>

                <p>KANDU har også mye utstyr som kan lånes eller leies (avhengig av formål
                og arrangement) året rundt. Mesteparten av dette utstyret blir brukt på
                The Gathering hvert år.</p>

                <p>Som betalende medlem under 26 år vil du bli oppført på medlemslistene vi
                sender til staten. Vi får hvert år flere hundre tusen i støtte fra
                staten, basert på medlemstall. Denne støtten går til drift av KANDU,
                derunder kjøp av utstyr, lokale, aktiviteter og lignende.</p>

                <p>Som medlem i KANDU vil du også bli medlem i Hyperion – Norsk Forbund
                for Fantastisk Fritidsinteresser. Dette er en interesseorganisasjon som
                formidler støtte til og jober for interessene til organisasjoner som
                driver med datatraff, brettspill, live, sci-fi og mye annet – og KANDU
                er naturligvis medlem.</p>

                <p>KANDU håper derfor at flest mulig blir medlem og dermed støtter opp om
                apparatet som sørger for at TG finnes, år etter år :-)</p>
                <input type="radio" id="KanduMembershipChoice" value="0" name="data[KanduMembership][choice]" />
                    Ønsker ikke medlemskap i KANDU for <?=$year?><br />
                <input type="radio" id="KanduMembershipChoice" value="1" name="data[KanduMembership][choice]" />
                    Ønsker gratis medlemskap i KANDU for <?=$year?><br />
                <input type="radio" id="KanduMembershipChoice" value="2" name="data[KanduMembership][choice]" />
                    Ønsker betalt medlemskap i KANDU (støttegenererende, 50kr)<br />

                <p><em>NB!</em> Du er kun støttegenererende dersom du er under 26 år, men du kan
                naturligvis velge betalt medlemskap selv om du er <?=$age?> år :-)</p>
            </div>
        </div>
    </fieldset>
    <div class="actions">
        <?=$this->Form->submit(__("Save"), array('class' => 'btn success', 'name' => 'save'))?>
    </div>
    </form>
    <?php else:
        $action = $done['KanduMembership']['choice'];
        if($action == 0): ?>
            <h4>Du har valgt: Ønsker ikke medlemskap i KANDU for <?=$year?></h4>
            <p>NB! Merk at du ikke vil få tilsendt informasjon om aktivitetstilbud utenom det som sendes på crewlista.</p>
        <?php elseif($action == 1): ?>
            <h4>Du har valgt: Ønsker gratis medlemskap i KANDU for <?=$year?></h4>
            <?php if($age < 26): ?>
                <p>NB! Du er under 26 år, og kan generere statsstøtte som brukes til aktiviteter! Vi setter pris på om du vurderer betalt medlemskap for 50kr, valget nedenfor. Du står naturligvis helt fritt til å velge gratis medlemskap dersom du heller ønsker det.</p>
            <?php endif; ?>
        <?php elseif($action == 2): ?>
            <h4>Du har valgt: Ønsker betalt medlemskap i KANDU (støttegenererende, 50kr)</h4>
            <p>Takk for at du vil støtte KANDU! Du kan betale inn kontingenten på 50kr til konto 5081.05.36974. Merk betalinga med navnet ditt.</p>
        <?php endif; // $action == 0 ?>
        <?php if($action > 0): ?>
            <p>Informasjon om ditt valg samt personalia blir oversendt KANDU i løpet av kort tid.</p>
        <?php endif; // $action > 0 ?>
    <?php endif; ?>
<?php endif; ?>
