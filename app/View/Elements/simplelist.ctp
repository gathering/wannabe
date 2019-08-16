<?
/**
 * Easily create a list of items
 *
 * To save a form created with this list use ModelName->savesimplelist. Then pass lastSimple
 *
 * @param $modelname    Required    The name of the model to show.
 *
 * @param $primary_key  Optional    the models primary key if not 'id'.
 *
 * @param $list         Required    A list of models (as returned by findAll).
 *
 * @param $erroritem    Optional    If set the item with this primary key will receive error messages.
 *
 * @param $fields       Optional    An array of fields in the model to show. fieldname => 
 *                                  displyname
 *
 * @param $fieldClasses Optional    An array of classes used with a td if the key match a field
 *
 * @param $editfields   Optional    true to edit all fields, an array of fields otherwise.
 *
 * @param $dropdowns    Optional    has the same keys as $fields and contain an array of 
 *                                  possible values for the field. Note: dropdown overrdide 
 *                                  whatever is said in editfields.
 *
 * @param $dropdownlist Optional    Completly replaces $dropdowns when in use. The exception is 
 *                                  when a dropdown doesn't exist here. Then $dropdowns are used instead.
 *
 * @param $showempty    Optional    Show the empty option or not in the dropdowns
 *
 * @param $newitems     Optional    number of new empty items to add bellow the list.
 *
 * @param $newitem      Optional    the value used as a base for new items. This need the 
 *                                  same content as a item in $list
 *
 * @param $candelete    Optional    if true delete is allowed trough a checkbox (only if 
 *                                  editable)
 *
 * @param $boldfields   Optional    if any of these fields match the item gets the style 
 *                                  specified by $classes['bold']
 *
 * @param $formTarget   Optional    the $target parameter to formTag
 *
 * @param $formType     Optional    the $type parameter to formTag
 *
 * @param $formAttr     Optional    the $htmlAttributes parameter to formTag
 *
 * @param $submCaption  Optional    the $caption parameter to submit
 *
 * @param $submAttr     Optional    the $htmlAttributes parameter to submit
 *
 * @param $classes      Optional    An array that may contain one or more of the following:
 *                                  'bold'  =>  default value 'bold'
 *                                  'table' =>  default value 'list'
 *                                  'th'    =>  default value ''
 *                                  'td'    =>  default value ''
 *                                  'newtd' =>  default value ''
 *
 * @param $links        Optional    An array of links that will be added to the end of each 
 *                                  item with the primary_key appended to the end
 *
 * @param $viewlink     Optional    link to use on each row (with $primary_key appended to
 *                                  the end) if the list isn't editable.
 */

// Set the optional parameters to default values
$primary_key    = isset($primary_key) ? $primary_key : 'id';
$fields         = isset($fields) ? $fields : null;
$erroritem      = isset($erroritem) ? $erroritem : false;
$errormsg       = isset($errormsg) ? $errormsg : '<blink><big><strong>*</strong></big></blink>';
$fieldClasses   = isset($fieldClasses) ? $fieldClasses : null;
$editfields     = isset($editfields) ? $editfields : null;
$dropdowns      = isset($dropdowns) ? $dropdowns : null;
$dropdownlist   = isset($dropdownlist) ? $dropdownlist : null;
$newitems       = isset($newitems) ? $newitems : 0;
$newitem        = isset($newitem) ? $newitem : 0;
$candelete      = isset($candelete) ? $candelete : true;
$boldfields     = isset($boldfields) ? $boldfields : null;
$formTarget     = isset($formTarget) ? $formTarget : null;
$formType       = isset($formType) ? $formType : 'post';
$formAttr       = isset($formAttr) ? $formAttr : array();
$submCaption    = isset($submCaption) ? $submCaption : 'Lagre';
$submAttr       = isset($submAttr) ? $submAttr : array('name'=>'save', 'onclick' => 'javascript:window.opener.location.reload()');
$classes        = isset($classes) ? $classes : null;
$links          = isset($links) ? $links : null;
$viewlink       = isset($viewlink) && strlen($viewlink) ? $viewlink : null;
$showempty      = isset($showempty) ? $showempty : false;
$tableStyle     = isset($tableStyle) ? $tableStyle : null;

// Generate a list of fields if no specified
if(!$fields)
{
    foreach(array_keys($list[0]) as $field)
        $fields[$field] = strtoupper(substr($field, 0, 1)).substr($field, 1).':';
}

// Get all field classes ready
foreach($fields as $fieldname => $fieldvalue)
    if(!isset($fieldClases[$fieldname]))
        $fieldClases[$fieldname] = '';
        
// Prepare dropdowns
if($dropdowns) 
    foreach($dropdowns as &$dropdown)
        if(!$dropdown)
            $dropdown = array(); 



// Make sure the list always has a numerical index
$templist = $list;
$list = array();
foreach($templist as & $item)
    $list[] = &$item;

// Make sure all classes are defined
foreach(array('bold' => 'bold', 'table' => 'list', 'th' => '', 'td' => '') as $index => $value)
    if(!isset($classes[$index]))
        $classes[$index] = $value;

// This only needs to be done if it's editable
if($editfields)
{
    // Generate a list of edit fields
    if(is_array($editfields))
    {
        foreach($editfields as $index => $field)
            if(is_integer($index))
                $editfields[$field] = 'input';
    }
    else if($editfields === true)
    {
        $editfields = array();
        
        foreach($fields as $index => $field)
            $editfields[$index] = 'input';
    }

    // Set the viewlink if the list isn't editable
    if($viewlink)
        $links['Vis'] = $viewlink.($viewlink[strlen($viewlink) - 1] != '/' ? '/' : '');
        
    // Initiate the default new item
    if(!$newitem)
    {
        $newitem = array();
    }
    
    foreach($fields as $index => $value)
        if(!isset($newitem[$modelname][$index]))
            $newitem[$modelname][$index] = '';
        
    // Initiate all the new values
    for($i = 0; $i < $newitems; $i++)
    {
        $list['__new__'.$i] = $newitem;
        $list['__new__'.$i][$modelname][$primary_key] = '__new__'.$i;
    }    

    // Set the form
    echo '<form action="'.$formTarget.'" method="'.$formType.'">';
}

// Make all links proper
if($links)
    foreach($links as &$link)
        if($link)
            $link = $link[strlen($link) - 1] == '/' ? $link : $link.'/';
            
// Lets start to make the list
echo "<table class=\"$classes[table]\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"$tableStyle\"><tr>";

if($editfields && $newitems)
    echo "<th width=\"1\" class=\"$classes[th]\">Ny</th>";

// Create a column for each field
foreach($fields as $fieldname => $displayname) 
    echo "<th class=\"$classes[th]\">$displayname</th>";

// Create the column needed for delete if needed
if($editfields && $candelete)
    echo "<th class=\"$classes[th]\">Slette</th>";

// Create a column for all links
if($links)
    echo "<th class=\"$classes[th]\">&nbsp;</th>";
    
// And the end of the header    
echo '</tr>';

// Create the list itself
if(count($list)) foreach($list as $index => $current)
{
    $bold = false; // True if entire line should be bold
    $isnewitem = substr($index, 0, 7) == '__new__' ? true : false; // True if it's a new item
    $haderrors = !$isnewitem && $current[$modelname][$primary_key] == $erroritem ? true : false;
    
    // Start of line    
    echo '<tr>';
    
    if($editfields)
	echo '<input type="hidden" name="data['.$current[$modelname][$primary_key].'][__save__]" value="" id="Save" />';
        //echo $form->hidden($current[$modelname][$primary_key].'.__save__');

    // Should this one be bold?        
    if($boldfields) foreach($boldfields as $fieldname => $cond)
        if(isset($current[$modelname][$fieldname]) && $current[$modelname][$fieldname] == $cond)
                $bold = true;

    // Set the class to use in all columns
    $tdclass = $bold ? "$classes[td] $bold" : $classes['td'];
    

    if($editfields && $newitems)
    {
        echo "<td width=\"1\" class=\"$tdclass\">";
        
        if($isnewitem)
        {
            echo $this->Form->checkbox($current[$modelname][$primary_key].'.__new__', null, array('checked' => 'false'));
        }
        else
        {
            echo '&nbsp;';
        }
        
        echo "</td>";
    }
    
    // Create the columns
    foreach($fields as $fieldname => $displayname)
    {
        echo "<td class=\"$fieldClasses[$fieldname] $tdclass\">";
            
        // Should this field be editable?
        if(isset($editfields[$fieldname]))
        {
            $tagname = $current[$modelname][$primary_key].'.'.$fieldname; // Name of the tag

            if(isset($dropdownlist[$index][$fieldname]))
                 echo $form->select($tagname, $dropdownlist[$index][$fieldname], (string)$current[$modelname][$fieldname], null, null, $showempty);
            else if(isset($dropdowns[$fieldname]))
                echo $form->select($tagname, $dropdowns[$fieldname], (string)$current[$modelname][$fieldname], null, null, $showempty);
            else
            {
                switch($editfields[$fieldname])
                {
                default:
                    trigger_error("Invalid editfields type specified (assuming input).");
                case 'input':
		    echo '<input type="text" value="'.$current[$modelname][$fieldname].'" name="data['.$current[$modelname][$primary_key].']['.$fieldname.']" />';
                    //echo $form->input($tagname, array('value' => $current[$modelname][$fieldname], 'label' => false));
                    break;
                    
                case 'checkbox':
                    echo $form->checkbox($current[$modelname][$primary_key].'.__checkbox__'.$fieldname, null, array('checked' =>  $current[$modelname][$fieldname] ? 'checked' : 
'false'));
                    break;
                }
            }
        }
        // Then it's a view
        else 
        {
            $fieldvalue = '';
            
            // Set the value (if a dropdown is specified get the proper value from there)
            if(isset($dropdownlist[$index][$fieldname]))
                $fieldvalue = $dropdownlist[$index][$fieldname][$current[$modelname][$fieldname]];
            else if(isset($dropdowns[$fieldname]))
                $fieldvalue = $dropdowns[$fieldname][$current[$modelname][$fieldname]];
            else
                $fieldvalue = $current[$modelname][$fieldname];
                
            // Print the value
            if($viewlink)
                echo $html->link($fieldvalue, $viewlink.$current[$modelname][$primary_key]);
            else 
                echo $fieldvalue;
        }
        
        if($haderrors)
        {
            $form->tagErrorMsg($modelname.'.'.$fieldname, $errormsg);
        }
        
        // End of the normal fields                    
        echo '</td>';
    }

    if($editfields)
    {
        if($candelete)
        {
            echo "<td class=\"$tdclass\">";

            if(!$isnewitem)
		echo '<input type="checkbox" name="data['.$current[$modelname][$primary_key].'][__delete__]" type="checkbox" 0="0" value="1" id="Delete" />';
                //echo $form->checkbox($current[$modelname][$primary_key].'.__delete__', null, array('checked' => 'unchecked'));
            else
                echo "&nbsp;";
                
            echo "</td>";
        }
    }
    
    if(!$isnewitem)
    {
        // And add the links in the end
        if($links)
        {
            $curlinks = array();
            
            foreach($links as $text => $link)
                if($link)
                    $curlinks[] = $html->link($text, $link.$current[$modelname][$primary_key]);
            
            echo "<td class=\"$tdclass\">".implode('&nbsp;', $curlinks)."</td>";
        }
    
        // End of the row            
        echo '</tr>';
    }
}    

// End of the list
echo '</table>';

if($editfields)
{
    echo $this->Form->submit($submCaption, $submAttr);
    echo '</form>';
}

?>
