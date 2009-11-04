<?php 
/* Created on: <02-11-2009 12:00:00 jbenoit>
 * 
 * @version    1.0
 * @package    epoAgreement
 * @subpackage datatypes.epoagreementcheckbox
 * @author     epo-jbenoit <jbmurat@messcenes.fr>
 * @copyright  Copyright (C) 2009 www.e-nitiativepopulaire.fr
 * @license    GNU General Public License v2.0
 *
 * NOTICE: >
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of version 2.0 of the GNU General
 *  Public License as published by the Free Software Foundation.
 * 
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of version 2.0 of the GNU General
 *  Public License along with this program; if not, write to the Free
 *  Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *  MA 02110-1301, USA.
 * 
 * THANKS TO: >
 *  Special thanks to Thomas Koch for his tutorial "Creating Datatypes in eZ Publish 4"
 *  You can read this tutorial at http://ez.no/fr/developer/articles/creating_datatypes_in_ez_publish_4
 */

/*!
 \class epoAgreementCheckBoxType epoagreementcheckboxtype.php
 \brief epoAgreementCheckBoxType is the datatype for eZPublish4 representing a PHP DateTime from user agreement.

 This class is used to hide php datetime behind a checkbox as an eZPublish 4 datatype. This  datatype ca be use for
 example in User content class to tell him his agreement during registering

 See also these classes: 
 \sa epoAgreementCheckBox, eZDataType

*/

class epoAgreementCheckBoxType extends eZDataType
{
    const DATATYPE_STRING = 'epoagreementcheckbox';
    const FORMS_STRING    = '_epoAgreementCheckBox';

    /**
     * Where is stored the node id of the article that contains full agreement terms
     */
    const CLASSATTRIBUTE_AGREEMENT_NODE_ID = 'data_int1';

    /**
     * Wich input name is used to post de date of agreement ('' or current date)
     */
    const OBJECTFORM_NAME = 'agreementdate';
    
    /**
     * Announces datatype identifier and human readable name to eZDataType.
     *
     */
    public function __construct()
    {
        parent::__construct( self::DATATYPE_STRING, 'Agreement CheckBox' );
    }

    // --------------------------------------
    // Methods concerning the CLASS attribute
    // --------------------------------------

    /**
     * Sets default values for a new class attribute.
     *
     * This attribute supports only one optione, whether a new object
     * attribute should be prefilled with the current date or not.
     *
     * @param mixed $classAttribute Class eZContentClassAttribute.
     *
     * @return void
     */
    public function initializeClassAttribute( $classAttribute )
    {
        /*if ( NULL === $classAttribute->attribute( self::CLASSATTRIBUTE_DEFAULT ) )
        {
            $classAttribute->setAttribute( self::CLASSATTRIBUTE_DEFAULT,
                                           self::DEFAULT_EMTPY );
        }*/
    }

    /**
     * Validates the input from the class definition form concerning this attribute.
     *
     * @param mixed  $http           Class eZHTTPTool.
     * @param string $base           Seems to be always 'ContentClassAttribute'.
     * @param mixed  $classAttribute Class eZContentClassAttribute.
     *
     * @return int eZInputValidator::STATE_INVALID/STATE_ACCEPTED
     */
    public function validateClassAttributeHTTPInput( $http, $base, $classAttribute )
    {
        $form = epoDatatypeForm::getInstance(
            'epoDatatypeAgreementCheckBoxClassForm',
            $classAttribute->attribute( 'id' )
        );

        if( !$form->isValid() )
        {
            return eZInputValidator::STATE_INVALID;
        }

        return eZInputValidator::STATE_ACCEPTED;
    }

    /**
     * Handles the input specific for one attribute from the class edit interface.
     *
     * In the case of ymcDateTime the user can choose, whether the attribute should
     * be prefilled with the actual date or not.
     *
     * @param mixed  $http      Class eZHTTPTool.
     * @param string $base      Seems to be always 'ContentClassAttribute'.
     * @param mixed  $attribute Class eZContentClassAttribute.
     *
     * @return void
     */
    public function fetchClassAttributeHTTPInput( $http, $base, $attribute )
    {
        $form = epoDatatypeForm::getInstance(
            'epoDatatypeAgreementCheckBoxClassForm',
            $attribute->attribute( 'id' )
        );

        if( !$form->isValid() )
        {
            return;
        }

        $attribute->setAttribute(
            self::CLASSATTRIBUTE_AGREEMENT_NODE_ID,
            $form->agreementnodeid
        );
    }

    // ---------------------------------------
    // Methods concerning the OBJECT attribute
    // ---------------------------------------

    /**
     * Transfers the data from an old to a new version of an object attribute.
     *
     * The default value for an attribute of a totaly new instance of an
     * object is set in $this->objectAttributeContent().
     *
     * @param mixed $attribute         Class eZContentObjectAttribute.
     * @param mixed $version           Should be NULL on initial obj creation.
     * @param mixed $originalAttribute Class eZContentObjectAttribute.
     *
     * @return void
     */
    public function initializeObjectAttribute( $attribute, $version, $originalAttribute )
    {
        $data = (string)new epoAgreementCheckBox( 'now' );

        $attribute->setAttribute( "data_text", $data );
    }

    /**
     * Returns the content object of the attribute.
     *
     * If the data of the attribute is empty, then the attribute is
     * initialized with an "empty" datetime or the current date depending on
     * the setting in the class edit dialog.
     *
     * @param mixed $objectAttribute Class eZContentObjectAttribute.
     *
     * @return epoAgreementCheckBox
     */
    public function objectAttributeContent( $objectAttribute )
    {
        return epoAgreementCheckBox::createFromString(
            $objectAttribute->attribute( 'data_text' )
        );
    }

    /**
     * Validates the input from the object edit form concerning this attribute.
     *
     * Validation can be done most effective by trying to instantiate a
     * Datetime. The instantiated object is saved in $form->cache to
     * reuse it in fetchObjectAttributeHTTPInput.
     *
     * @param mixed  $http      Class eZHTTPTool.
     * @param string $base      Seems to be always 'ContentObjectAttribute'.
     * @param mixed  $attribute Class eZContentObjectAttribute.
     *
     * @return int eZInputValidator::STATE_INVALID/STATE_ACCEPTED
     */
    public function validateObjectAttributeHTTPInput( $http, $base, $attribute )
    {
        $form = epoDatatypeForm::getInstance(
            'epoDatatypeAgreementCheckBoxObjectForm',
            $attribute->attribute( 'id' )
        );

        $field = self::OBJECTFORM_NAME;
        $is_required=$attribute->contentClassAttribute()->attribute( "is_required" );

		if( !$form->hasValidData( $field ) && $is_required)
		{
			$attribute->setValidationError(
				ezi18n( 'extension/epoagreement', 'You must accept terms.' ) );
			return eZInputValidator::STATE_INVALID;
		}
		
		if($form->hasValidData( $field ) && $form->$field!='')
		{
			try{
				$form->cache = new epoAgreementCheckBox( $form->$field );
			}
			catch( epoAgreementInvalidParamsException $e )
			{
				return eZInputValidator::STATE_INVALID;
			}
		}
        return eZInputValidator::STATE_ACCEPTED;
    }

    /**
     * Stores the object attribute input in the $contentObjectAttribute.
     *
     * The ymcDatatypeDateTime object instantiated in
     * validateObjectAttributeHTTPInput is reused.
     *
     * @param mixed  $http      Class eZHTTPTool.
     * @param string $base      Seems to be always 'ContentObjectAttribute'.
     * @param mixed  $attribute Class eZContentObjectAttribute.
     *
     * @return boolean Whether to save the changes to the db or not.
     */
    public function fetchObjectAttributeHTTPInput( $http, $base, $attribute )
    {
        $form = epoDatatypeForm::getInstance(
            'epoDatatypeAgreementCheckBoxObjectForm',
            $attribute->attribute( 'id' )
        );
		
        $is_required=$attribute->contentClassAttribute()->attribute( "is_required" );
		if ($is_required)
		{
			if( NULL === $form->cache ) return false;
			
			$attribute->setAttribute('data_text', (string)$form->cache );
		}
		else
		{
			if( NULL === $form->cache )	$attribute->setAttribute('data_text', '' );
			else $attribute->setAttribute( 'data_text',	(string)$form->cache );
		}
		
		return true;
    }

    /**
     * Returns whether the attribute contains data.
     *
     * @param mixed $contentObjectAttribute Class eZContentObjectAttribute.
     *
     * @return boolean
     */
    public function hasObjectAttributeContent( $contentObjectAttribute )
    {
        return $contentObjectAttribute
               ->content()
               ->hasContent();
    }

    /**
     * Returns a key to sort attributes.
     *
     * @param mixed $contentObjectAttribute Class eZContentObjectAttribute.
     *
     * @return string
     */
    public function sortKey( $contentObjectAttribute )
    {
        return $contentObjectAttribute
               ->content()
               ->timeStamp;
    }

    /**
     * Returns the type of the sortKey.
     *
     * I better use string in favor of integer as I do not know if the integer
     * type used by eZP is big enough.
     *
     * @return string
     */
    public function sortKeyType()
    {
        return 'string';
    }

    /**
     * Returns a MetaData string for the search functionality.
     *
     * @param mixed $contentObjectAttribute Class eZContentObjectAttribute.
     *
     * @return string
     */
    public function metaData( $contentObjectAttribute )
    {
        return $contentObjectAttribute
               ->content()
               ->fullInfo;
    }

    /**
     * IsIndexable.
     *
     * @return boolean
     */
    public function isIndexable()
    {
        return true;
    }

    /**
     * Returns a string that could be used for the object title.
     *
     * @param mixed $contentObjectAttribute ContentObjectAttribute.
     * @param mixed $name                   No idea...
     *
     * @return string
     */
    public function title( $contentObjectAttribute, $name = null )
    {
        return $contentObjectAttribute
               ->content()
               ->fullInfo;
    }
}

eZDataType::register( epoAgreementCheckBoxType::DATATYPE_STRING, "epoAgreementCheckBoxType" );
