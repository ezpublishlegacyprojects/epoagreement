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
 \class epoAgreementCheckBox epoagreementcheckbox.php
 \brief epoAgreementCheckBox is the content class for epoAgreementCheckBoxType.

 This is the content class for epoAgreementCheckBoxType.

 See also these classes: 
 \sa epoAgreementCheckBoxType

*/

class epoAgreementCheckBox
{
    const FORMAT_MYSQL_FULL            = 'Y-m-d H:i:s';
    const FORMAT_UNIX_TIMESTAMP        = 'U';
    const FORMAT_FULL_INFO             = DATE_ATOM;

    /**
     * Contains the actual content data of this class.
	 * $dateTime is null if no agreement has been given
     *
     * @var DateTime
     */
    private $dateTime = NULL;

    /**
     * Constructs a new epoAgreementCheckBox instance.
     *
     * The parameters can be ommited which leads to empty strings for all
     * attributes.
     *
     * @param string $dtString A valid first parameter for DateTime::__construct().
     *
     * @throws epoAgreementInvalidParamsException
     */
    public function __construct( $dtString = NULL )
    {
        if( is_string( $dtString ) && $dtString!='' )
        {
            try
            {
                $this->dateTime = new DateTime( $dtString );
            }
            catch( Exception $e )
            {
                throw new epoAgreementInvalidParamsException( $dtString.' is no valid DateTime string.');
            }
        }
    }

    /**
     * Returns the attribute $name.
     *
     * @param string $name Of the attribute.
     *
     * @return mixed
     */
    public function attribute( $name )
    {
        return $this->__get( $name );
    }

    /**
     * Checks, if the attribute $name exists.
     *
     * @param string $name Of the attribute.
     *
     * @return boolean
     */
    public function hasAttribute( $name )
    {
        return $this->__isset( $name );
    }

    /**
     * Returns the virtual property $name.
     *
     * @param string $name Of the attribute.
     *
     * @see    self::$virtualProperties
     * @throws ezcBasePropertyNotFoundException For undefined properties.
     * @return mixed
     */
    public function __get( $name )
    {
        if( $name=='dateTime' )
        {
            if( NULL === $this->dateTime )
            {
                return '';
            }
            return $this->dateTime;
        }
		else if( $name=='timeStamp')
		{
			if ( NULL === $this->dateTime ) return 0;
			else return $this->dateTime->format( self::FORMAT_UNIX_TIMESTAMP );
		}
		else if( $name=='fullInfo')
		{
			if ( NULL === $this->dateTime ) return '';
			else return $this->dateTime->format( self::FORMAT_FULL_INFO );
		}
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Checks, if the attribute $name exists.
     *
     * @param string $name Of the attribute.
     *
     * @return boolean
     */
    public function __isset( $name )
    {
        return ($name=='dateTime');
    }

    /**
     * Returns whether the object contains data.
     *
     * @return boolean
     */
    public function hasContent()
    {
        return NULL !== $this->dateTime;
    }

    /**
     * Returns a string representation of the datetime object.
     *
     * This string can also be used to save the data to the database.
     * 
     * @return string
     */
    public function __toString()
    {
        if( NULL === $this->dateTime )
        {
            return '';
        }
		
        return $this->dateTime->format( self::FORMAT_MYSQL_FULL );
    }

    /**
     * Returns an instance of self with the data of $string.
     *
     * If an empty string is given, then the returned object is like one
     * returned by new epoAgreementCheckBox without parameters.
     * 
     * @param string $string Must be exactly as returned by __toString().
     *
     * @return epoAgreementCheckBox
     */
    public static function createFromString( $string )
    {
        if( is_null($string) || '' === $string )
        {
            return new self;
        }
        return new self($string);
    }
}
