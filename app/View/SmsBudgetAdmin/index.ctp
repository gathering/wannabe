<script>
    // http://en.wikipedia.org/wiki/Closure_(computer_science)
    $(function() {
        $('tr').each(function(i, row) {
            $(row).find('a.edit').click(function() {
                curVal = $(row).find('span.curlimit').html();
                $(row).find('input.editlimit').val(curVal);
                $(row).addClass('editmode');
            });
            $(row).find('a.save').click(function() {
                var newVal = $(row).find('input.editlimit').val();
                if (newVal != '') {
                    $(row).find('form').submit(); 
                }
            }); 
            $(row).find('a.block').click(function() {
                curSent = $(row).find('span.cursent').html();
                $(row).find('input.editlimit').val(curSent); 
                $(row).find('form').submit(); 
            }); 
            $(row).find('a.create').click(function() {
                if ($('.userid').val() > 0 && $('.smslimit').val() > 0) {
                    $(row).find('form').submit(); 
                }
            }); 
        });
        $('#addnew').click(function() {
            $(this).addClass('createnewbudget');
            $('tr.createnewbudget').removeClass('createnewbudget');
        });
        $('.emptyonclick').focus(function() {
            $(this).val('');
        });
    });
</script>

<table id="budgets">
    <thead>
        <tr>
            <th>User</th>
            <th>Sent SMS</td>
            <th>SMS limit</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($budgets as $budget) { ?>
        <tr>
            <form method="post">
                <td><?= $this->Wb->userLink($budget) ?></td>
                <td><span class="cursent"><?= $budget['SmsBudget']['sms_sent'] ?></span></td>
                <td class="limit">
                    <span class="curlimit"><?= $budget['SmsBudget']['sms_limit'] ?></span>
                    <input type="text" name="sms_limit" class="editlimit shortinput" />
                    <input type="hidden" name="id" value="<?= $budget['SmsBudget']['id'] ?>" />
                </td>
                <td class="buttongroup">
                    <a href="#" class="btn edit">Edit limit</a>
                    <a href="#" class="btn success save">Save changes</a>
                    <a href="#" class="btn error block">Block</a>
                </td>
            </form>
        </tr>
    <?php } ?>
        <tr class="createnewbudget">
            <form action="SmsBudgetAdmin/add" method="post">
                <td><input type="text" name="user_id" value="User ID" class="emptyonclick userid" /></td>
                <td></td>
                <td><input type="text" name="sms_limit" value="SMS limit" class="emptyonclick smslimit shortinput" /></td>
                <td><a href="#" class="btn success create">Create</a></td>
            </form>
        </tr>
    </tbody>
</table>
    
<a href="#" id="addnew" class="btn success">Add new budget</a>
