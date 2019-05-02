<div class="panel mymodule-admin-panel">
    <div class="panel-heading">
        <i class="icon-cogs"></i> {l s='Custom Admin' d='Modules.mymodule'}
    </div>
    <div class="form-wrapper">       
        <form action="{$mymodule.postAction}" method="post" enctype="application/x-www-form-urlencoded,multipart/form-data">
            <div class="form-group">													
                <label class="control-label col-lg-3">
                    {$mymodule.customControls['MYMODULE_SAVE_NAME']['label']}
                </label>
                <div class="col-lg-3">	
                    <div class="form-group">
                        {foreach item=lang from=$mymodule.languagesArray}  
                            <div class="translatable-field lang-{$lang["id_lang"]}" 
                                 {if $mymodule.currentLang != $lang["id_lang"]}style="display: none;"{/if}>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="icon-user"></i>
                                        </span>                                
                                        <input type="text" 
                                            id="{$mymodule.customControls['MYMODULE_SAVE_NAME']['controlName']}_{$lang["id_lang"]}"
                                            name="{$mymodule.customControls['MYMODULE_SAVE_NAME']['controlName']}_{$lang["id_lang"]}"
                                            class="mymodule-language" value="{$mymodule.customControls['MYMODULE_SAVE_NAME']['values'][$lang["id_lang"]]}"
                                            onkeyup="if (isArrowKey(event)) return ;updateFriendlyURL();"/>
                                    </div>                                  
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                        {$lang["iso_code"]}
                                        <i class="icon-caret-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        {foreach item=lang from=$mymodule.languagesArray} 
                                            <li><a href="javascript:hideOtherLanguage({$lang["id_lang"]});" tabindex="-1">{$lang["name"]}</a></li>
                                        {/foreach}
                                    </ul>
                                </div> 
                            </div>                           
                        {/foreach}                       
                    </div>  
                    <p class="help-block">
                        {$mymodule.customControls['MYMODULE_SAVE_NAME']['desc']}
                    </p>
                </div>      
            </div> 
            <div class="form-group">													
                <label class="control-label col-lg-3">
                    {$mymodule.customControls['MYMODULE_SAVE_LAST_NAME']['label']}
                </label>											            
                <div class="col-lg-3">	
                    <div class="form-group">
                        {foreach item=lang from=$mymodule.languagesArray}  
                            <div class="translatable-field lang-{$lang["id_lang"]}" {if $mymodule.currentLang != $lang["id_lang"]}style="display: none;"{/if}>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="icon-user"></i>
                                        </span>                                
                                        <input type="text" id="{$mymodule.customControls['MYMODULE_SAVE_LAST_NAME']['controlName']}_{$lang["id_lang"]}" name="{$mymodule.customControls['MYMODULE_SAVE_LAST_NAME']['controlName']}_{$lang["id_lang"]}" class="mymodule-language" value="{$mymodule.customControls['MYMODULE_SAVE_LAST_NAME']['values'][$lang["id_lang"]]}" onkeyup="if (isArrowKey(event)) return ;updateFriendlyURL();"/>
                                    </div>                                  
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                        {$lang["iso_code"]}
                                        <i class="icon-caret-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        {foreach item=lang from=$mymodule.languagesArray} 
                                            <li><a href="javascript:hideOtherLanguage({$lang["id_lang"]});" tabindex="-1">{$lang["name"]}</a></li>
                                        {/foreach}
                                    </ul>
                                </div> 
                            </div>                           
                        {/foreach}               
                    </div>
                    <p class="help-block">
                        {$mymodule.customControls['MYMODULE_SAVE_LAST_NAME']['desc']}
                    </p>

                </div>   
            </div>
                    
            <div class="form-group">													
                <label class="control-label col-lg-3">
                    {$mymodule.customControls['MYMODULE_HTML']['label']}
                </label>											            
                <div class="col-lg-3">	
                    <div class="form-group">
                        {foreach item=lang from=$mymodule.languagesArray}  
                            <div class="translatable-field lang-{$lang["id_lang"]}" {if $mymodule.currentLang != $lang["id_lang"]}style="display: none;"{/if}>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="icon-info"></i>
                                        </span>                                
                                        <textarea id="{$mymodule.customControls['MYMODULE_HTML']['controlName']}_{$lang["id_lang"]}" name="{$mymodule.customControls['MYMODULE_HTML']['controlName']}_{$lang["id_lang"]}" class="mymodule-language">{$mymodule.customControls['MYMODULE_HTML']['values'][$lang["id_lang"]]}</textarea>
                                    </div>                                  
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                        {$lang["iso_code"]}
                                        <i class="icon-caret-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        {foreach item=lang from=$mymodule.languagesArray} 
                                            <li><a href="javascript:hideOtherLanguage({$lang["id_lang"]});" tabindex="-1">{$lang["name"]}</a></li>
                                        {/foreach}
                                    </ul>
                                </div> 
                            </div>                           
                        {/foreach}               
                    </div>
                    <p class="help-block">
                        {$mymodule.customControls['MYMODULE_HTML']['desc']}
                    </p>
                </div> 
            </div>
                    
            <div class="panel-footer">
                <button type="submit" value="1" id="{$mymodule.saveButton['MYMODULE_SAVE_FORM']['controlName']}" 
                        name="{$mymodule.saveButton['MYMODULE_SAVE_FORM']['controlName']}" class="btn btn-default pull-right">
                    <i class="process-icon-save"></i> {$mymodule.saveButton['MYMODULE_SAVE_FORM']['label']}
                </button>
            </div>   
        </form> 
    </div>    
</div>