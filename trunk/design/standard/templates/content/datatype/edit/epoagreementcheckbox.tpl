{default $attribute_base='ContentObjectAttribute' }
<div class="block">
  <div class="epoagreementcheckbox-edit">
    {if $attribute.contentclass_attribute.data_int1|gt(0)}
      {def $article=fetch( 'content', 'node', hash( 'node_id', $attribute.contentclass_attribute.data_int1 ) )}
      {if $article}
          <div class="epoagreementcheckbox-summary">
          {attribute_view_gui attribute=$article.data_map.intro}
          </div>
          <div class="epoagreementcheckbox-link">
          <a href={concat('content/view/full/', $attribute.contentclass_attribute.data_int1)|ezurl()} target="_blank">{"This text is only an introduction of the terms that need your agreement. If you want to read the full version, click here."|i18n("extension/epoagreement")}</a>
          </div>
      {/if}
    {/if}
    <div class="labelbreak"></div>
    <div class="epoagreementcheckbox-input">
	  <input type="checkbox" name="{$attribute_base}_epoAgreementCheckBox_agreementdate_{$attribute.id}" value="{$attribute.content}"/>{"I accept these terms"|i18n("extension/epoagreement")}
    </div>
  </div>
  <div class="break"></div>
</div>