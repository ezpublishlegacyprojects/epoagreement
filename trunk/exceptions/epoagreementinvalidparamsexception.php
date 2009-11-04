<?php 
/* Created on: <02-11-2009 12:00:00 jbenoit>
 * 
 * @version    1.0
 * @package    epoAgreement
 * @subpackage exceptions
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
 \class epoAgreementInvalidParamsException epoagreementinvalidparamsexception.php
 \brief epoAgreementInvalidParamsException is used to extends ezcBaseException for epoAgreement extension specific purposes.

 This class is used extends ezcBaseException and allow to customize exception message.

 See also these classes: 
 \sa ezcBaseException
*/

class epoAgreementInvalidParamsException extends ezcBaseException
{
    /**
     * Constructs a new epoAgreementInvalidParamsException with message $msg.
     *
     * @param string $msg Error message.
     */
    public function __construct( $msg )
    {
        parent::__construct( 
            "Function parameters are not valid.\n".
            $msg
        );
    }
}

?>
