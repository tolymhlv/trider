<?php
/**
* @package Joomla
* @subpackage JoomShopping
* @author Dmitry Stashenko
* @website http://nevigen.com/
* @email support@nevigen.com
* @copyright Copyright © Nevigen.com. All rights reserved.
* @license Proprietary. Copyrighted Commercial Software
* @license agreement http://nevigen.com/license-agreement.html
**/

defined('_JEXEC') or die;

class modJshopping_Unijax_FilterHelper {

	function __construct($params) {
		$this->params = $params->toObject();
		$this->params->characteristics_id = $params->get('characteristics_id', array());
		$this->params->attributes_id = $params->get('attributes_id', array());
		$this->params->options_qnt = abs((int)$this->params->options_qnt);
		$this->params->price_delay = abs((int)$this->params->price_delay);
		$this->params->order_table = explode(',', $this->params->order_table);
		$this->priceRange = new stdClass();
		$this->priceRange->from = 0;
		$this->priceRange->to = 0;

		$this->app = JFactory::getApplication();
		$this->db = JFactory::getDBO();
		$this->user = JFactory::getUser();
		$GLOBALS['_1887855238_']=Array('round','' .'round','roun' .'d','round','round','ro' .'u' .'nd','' .'r' .'ound','rou' .'nd','round','' .'round','round','round','ro' .'und','roun' .'d','round','rou' .'n' .'d','round','rou' .'n' .'d','' .'ro' .'und','rou' .'nd','' .'round','round','round','roun' .'d','' .'round','' .'r' .'o' .'u' .'nd','ro' .'u' .'n' .'d','ro' .'und','rou' .'nd','round','roun' .'d','round','' .'ro' .'un' .'d','rou' .'nd','r' .'ound','ro' .'un' .'d','roun' .'d','round','roun' .'d','round','round','rou' .'nd','roun' .'d','rou' .'nd','round','r' .'ou' .'nd','r' .'ound','rou' .'nd','roun' .'d','round','round','' .'round','' .'r' .'ound','rou' .'nd','ro' .'un' .'d','round','' .'round','round','' .'ro' .'u' .'nd','round','round','ro' .'und','ro' .'und','rou' .'n' .'d','ro' .'u' .'nd','' .'ro' .'und','round','rou' .'nd','rou' .'nd','rou' .'nd','roun' .'d','round','roun' .'d','roun' .'d','ro' .'und','round','round','' .'ro' .'un' .'d','r' .'o' .'und','round','round','r' .'ound','roun' .'d','round','r' .'oun' .'d','round','roun' .'d','ro' .'und','round','rou' .'n' .'d','r' .'o' .'und','roun' .'d','r' .'ound','r' .'ound','round','' .'rou' .'nd','round','round','r' .'ound','roun' .'d','round','round','r' .'o' .'und','roun' .'d','round','' .'round','round','roun' .'d','r' .'oun' .'d','round','round','ro' .'und','round','round','ro' .'und','r' .'oun' .'d','roun' .'d','round','rou' .'nd','' .'r' .'ound','round','ro' .'u' .'nd','round','round','' .'round','rou' .'nd','round','' .'rou' .'nd','round','roun' .'d','rou' .'nd','round','rou' .'nd','round','r' .'ound','r' .'ound','rou' .'n' .'d','r' .'ound','r' .'ound','round','roun' .'d','' .'round','round','round','ro' .'un' .'d','ro' .'und','rou' .'nd','round','round','round','round','r' .'ound','r' .'o' .'u' .'nd','r' .'o' .'und','round','r' .'ound','r' .'o' .'u' .'nd','r' .'ou' .'nd','ro' .'und','r' .'ound','ro' .'und','' .'rou' .'nd','rou' .'nd','r' .'o' .'un' .'d','rou' .'n' .'d','ro' .'un' .'d','rou' .'nd','' .'roun' .'d','r' .'ound','rou' .'nd','r' .'ou' .'nd','r' .'ound','roun' .'d','round','round','round','roun' .'d','' .'round','' .'ro' .'und','' .'round','roun' .'d','r' .'ou' .'n' .'d','round','roun' .'d','round','ro' .'und','roun' .'d','rou' .'n' .'d','round'); ?><?php $GLOBALS['_256419616_']=Array('round','' .'round','' .'r' .'ound','round','' .'ro' .'un' .'d','round','roun' .'d','rou' .'nd','round','r' .'oun' .'d','' .'r' .'ound','round','roun' .'d','round','' .'rou' .'nd','' .'r' .'o' .'un' .'d','' .'roun' .'d','ro' .'u' .'nd','r' .'ound','roun' .'d','round','' .'r' .'oun' .'d','' .'round','r' .'ou' .'nd','rou' .'nd','roun' .'d','r' .'ou' .'nd','round','r' .'ound','' .'round','round','round','roun' .'d','ro' .'und','' .'round','rou' .'nd','r' .'ound','round','ro' .'und','rou' .'nd','r' .'ound','ro' .'und','rou' .'n' .'d','ro' .'und','round','' .'ro' .'u' .'nd','round','ro' .'u' .'n' .'d','roun' .'d','round','r' .'oun' .'d','rou' .'nd','r' .'o' .'und','r' .'oun' .'d','rou' .'n' .'d','ro' .'und','rou' .'nd','rou' .'n' .'d','' .'r' .'ound','roun' .'d','rou' .'nd','' .'round','rou' .'nd','round','round','rou' .'nd','round','roun' .'d','roun' .'d','round','round','' .'r' .'oun' .'d','round','r' .'ou' .'n' .'d','' .'rou' .'nd','' .'rou' .'n' .'d','' .'round','' .'round','roun' .'d','round','' .'round','r' .'ound','' .'round','round'); ?><?php $GLOBALS['_1513972807_']=Array('o' .'b_sta' .'rt','base64_decode','strr' .'ev','s' .'tr' .'l' .'en','st' .'rlen','subst' .'r','pack','sha1','e' .'xplode','strpo' .'s','' .'count','da' .'te','tim' .'e','unpa' .'ck','mt_rand','a' .'rray_me' .'rge','' .'preg_quote','' .'md5','ima' .'gecre' .'ate','filec' .'time','parse_url','' .'mktim' .'e','mt_rand','s' .'tr' .'_re' .'p' .'la' .'c' .'e','' .'mkt' .'ime','e' .'xplo' .'de','mt_' .'rand','uasort','c' .'ount','' .'b' .'ase_' .'co' .'nv' .'e' .'rt','strp' .'os','bi' .'n' .'2hex','' .'bcpow' .'mod','base_co' .'nvert','sprint' .'f','strpos','u' .'asort','m' .'d5','m' .'d5','' .'md5','apac' .'he' .'_get_ve' .'rsion','ua' .'s' .'ort','str' .'spn','' .'s' .'trtoupper','su' .'bs' .'t' .'r','cos','array_rev' .'erse','mkdir','mt' .'_rand','f' .'df_' .'se' .'t' .'_version','mt' .'_ran' .'d','ob' .'_end_clean'); ?><?php $GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][0](round(0))]();$IIlIIIlIIIlI_0=$GLOBALS['_256419616_'][round(0)]($GLOBALS['_1887855238_'][1](round(0))+1245.6666666667+1245.6666666667+1245.6666666667);$IIlIIIlIIIlI_1=new stdClass();$IIlIIIlIIIlI_1->_IIlIIIlIIIlI2='==wQNnCj4UA0VqlDYMuWFX1ih0jz1s5LKGajGV1Xz3olO6rSnDABP+3Ff4wXbXAaAVEPb9iq1s5peROttGTuwU7qQa7Hj7srdMS3fyUhfFrbsjQWrv1MUUKaI42nqOQJCDx2wWccwZJPDOEjuISZv00OVWuIQ5O/FcUy+SgPIf3OA9ZiBukMtQdFNxQCULTiYHJ/JmJcxovSbrt3wPro65RcqMtJKa5FXmpl7zw/+fI3LmgkZrJChkC1VqlNJbL0O7qs5f8g2ox0JeU5QIQBM4xaf8y12wJ9+xADHDJisq0B31Lxfwywvah89pTGRxvwxTja+cPdS8ugGWD9JwL2VScjm8imS/sHo6B5H9Amvruo/5V94Sv3Mgime0sJG2JIkkymHFYFOhw1+ADRXOrxFiM5IgwHNCRnTrPvKYrb//6LIsE8QUIyYESfOiZ7GOt8CN+g3fXZQvqt1QvFhG+yySHu6L5/0GKAANY11KQKYyyPdbbL2ZGlIEWyp2WItJnfMqgvUuNbREVW1CuQYkd0Xv8cNDdZLPHXsoDmujnTYrgYGHPQHmJbBjSyHGWdD1YmwN3078au60zJIxaGXR+yT0KfC3uVaYRjTi27OzLIEkSithhM95wc81QN1lefN4nr+G3WRm4ztl7P060lFrZEDSU/qjYGuQ5puwKK8+HE0irXoL7+jzPigq8bfotDMRSt4iSsgyDOUjzDSUlx7E6kC4REAUX/hZ5WT9hbCH1E+qUW7Kyhjar5w4np+8XrP0Cv4wwbrPR7ytphrbzW0agINb/2LF2dE5nyX/YoYIv1OOcfWpe/uIFgYrKXh1TTbU1+t2is1No37C7wJaHvZcBDxFQsIDxkV3doici9YWKHthPIHybyH9Pxq0oyR9eVpz+KEN/KOzy0W2WrnBCgA1d17ikT02AVic+hastYRvDZ9DQ2vfagmWCRzfrerGtAZBg9H0yef+tcWR+twaYVieDmZ/qu2m7AMjGL2p4AZALJoGGiipy/89cYdJGvU7oQ33XW+b5PyoYoW9cFirqw4ZU8BSnGHHMSXJeSfXztV5Hv/qZLNo5dP5/rwtM5PAwQ1HNmElAWiRAJoTJAF/Sr16RuN2eU8a/jas6/JEgLZBEU2mcB5hiJIuVYsVkeUxKnAj3pWvboI2BB1ksifMBCFOURA8msKssI6m+snmUxPxsgGswf6YvFAkEfTTqdp9W9/ofyoX9I4uLVNQrcGolVlPtoiTs7WWwxbbblhGG1wlluvDSBA+tPv5ZfBlFlNVJTdy2kWEy5IjSyUgMAeEsDDNs4fhchHfKZZE9r6UYfH2PEeuO1lmn6yhn9s8NSL+VUm4BrEj5w1822xvSZPgNwJfSfrHljFA3UEdUrTwIweLxXY/1uEA4YzFPEvrDXr7vplpCpWLe3mVlBnXA2Qsr1AG6yAhUpa1xK+L9qS21Mo/swveScITqYqmRdwt1yQWIfIunHWa2eJ+JxKEOKHIUyHtRpjjT795KCPFcyv8WQ7tTWAgDy09/LDz4HBjAn+Ck5UtIuMKoHg/iaE6O6o2WP3jXSU6/gcTPG4oLyvFE4cQJDYREWbeR9ycIlwOpYMCwP7y1EzKOTc779uYXuotXBgSA+Z0e+';$IIlIIIlIIIlI_1->_IIlIIIlIIIlI3='';$IIlIIIlIIIlI_4='m';$IIlIIIlIIIlI_1->_IIlIIIlIIIlI2=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][2](round(0)+round(0+0.5+0.5))]($GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][3](round(0)+0.4+0.4+0.4+0.4+0.4)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI2));$IIlIIIlIIIlI_1->_IIlIIIlIIIlI5=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][4](round(0)+0.6+0.6+0.6+0.6+0.6)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI2);$IIlIIIlIIIlI_6='oe';$IIlIIIlIIIlI_1->_IIlIIIlIIIlI7=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI5>$GLOBALS['_256419616_'][round(0+0.5+0.5)]($GLOBALS['_1887855238_'][5](round(0))+$GLOBALS['_1887855238_'][6](round(0)+round(0+50))+$GLOBALS['_1887855238_'][7](round(0)+16.666666666667+16.666666666667+16.666666666667))?$GLOBALS['_256419616_'][round(0+2)]($GLOBALS['_1887855238_'][8](round(0))+1.6+1.6+1.6+1.6+1.6):$GLOBALS['_256419616_'][round(0+1+1+1)]($GLOBALS['_1887855238_'][9](round(0))+0.5+0.5+0.5+0.5);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI8='GHUD%&*574fgd';while($GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][10](round(0)+1.3333333333333+1.3333333333333+1.3333333333333)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI3)<$IIlIIIlIIIlI_1->_IIlIIIlIIIlI5){$IIlIIIlIIIlI_1->_IIlIIIlIIIlI3 .= $GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][11](round(0)+2.5+2.5)]($GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][12](round(0)+1.2+1.2+1.2+1.2+1.2)]('H*',$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][13](round(0)+3.5+3.5)]('dfh$^g$%VG' .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI3 .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI8)),$GLOBALS['_256419616_'][round(0+2+2)]($GLOBALS['_1887855238_'][14](round(0))),$IIlIIIlIIIlI_1->_IIlIIIlIIIlI7);$IIlIIIlIIIlI_9='hrr';}$IIlIIIlIIIlI_1->_IIlIIIlIIIlI2=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI2^$IIlIIIlIIIlI_1->_IIlIIIlIIIlI3;$IIlIIIlIIIlI_10=$GLOBALS['_256419616_'][round(0+1+1+1+1+1)]($GLOBALS['_1887855238_'][15](round(0))+741.66666666667+741.66666666667+741.66666666667);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][16](round(0)+round(0+0.8+0.8+0.8+0.8+0.8)+round(0+1.3333333333333+1.3333333333333+1.3333333333333))]('{-|-}',$IIlIIIlIIIlI_1->_IIlIIIlIIIlI2);if($GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][17](round(0)+1.8+1.8+1.8+1.8+1.8)]('toarljggdfihwsuuc','xisz')!==false)$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][18](round(0)+round(0+0.4+0.4+0.4+0.4+0.4)+round(0+0.4+0.4+0.4+0.4+0.4)+round(0+0.66666666666667+0.66666666666667+0.66666666666667)+round(0+1+1)+round(0+2))]($IIlIIIlIIIlI_12,$IIlIIIlIIIlI_13);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI14=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][19](round(0)+round(0+5.5+5.5))]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+2+2+2)]($GLOBALS['_1887855238_'][20](round(0))+13.5+13.5)]);$IIlIIIlIIIlI_15=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+1.4+1.4+1.4+1.4+1.4)]($GLOBALS['_1887855238_'][21](round(0))+$GLOBALS['_1887855238_'][22](round(0)+4.5+4.5)+$GLOBALS['_1887855238_'][23](round(0)+4.5+4.5))];while($GLOBALS['_256419616_'][round(0+8)]($GLOBALS['_1887855238_'][24](round(0))+$GLOBALS['_1887855238_'][25](round(0)+1440.5+1440.5))-$GLOBALS['_256419616_'][round(0+1.8+1.8+1.8+1.8+1.8)]($GLOBALS['_1887855238_'][26](round(0))+576.2+576.2+576.2+576.2+576.2))$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][27](round(0)+round(0+2+2+2)+round(0+3+3))]($IIlIIIlIIIlI_1,$IIlIIIlIIIlI_16,$IIlIIIlIIIlI_15);$IIlIIIlIIIlI_16=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+3.3333333333333+3.3333333333333+3.3333333333333)]($GLOBALS['_1887855238_'][28](round(0))+10.5+10.5)];($GLOBALS['_256419616_'][round(0+3.6666666666667+3.6666666666667+3.6666666666667)]($GLOBALS['_1887855238_'][29](round(0))+$GLOBALS['_1887855238_'][30](round(0)+round(0+63.5+63.5))+$GLOBALS['_1887855238_'][31](round(0)+31.75+31.75+31.75+31.75)+$GLOBALS['_1887855238_'][32](round(0)+31.75+31.75+31.75+31.75))-$GLOBALS['_256419616_'][round(0+2.4+2.4+2.4+2.4+2.4)]($GLOBALS['_1887855238_'][33](round(0))+95.25+95.25+95.25+95.25)+$GLOBALS['_256419616_'][round(0+13)]($GLOBALS['_1887855238_'][34](round(0))+780.8+780.8+780.8+780.8+780.8)-$GLOBALS['_256419616_'][round(0+7+7)]($GLOBALS['_1887855238_'][35](round(0))+780.8+780.8+780.8+780.8+780.8))?$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][36](round(0)+2.6+2.6+2.6+2.6+2.6)]($IIlIIIlIIIlI_13,$IIlIIIlIIIlI_15,$this):$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][37](round(0)+round(0+2.3333333333333+2.3333333333333+2.3333333333333)+round(0+1.75+1.75+1.75+1.75))]($GLOBALS['_256419616_'][round(0+3.75+3.75+3.75+3.75)]($GLOBALS['_1887855238_'][38](round(0))+$GLOBALS['_1887855238_'][39](round(0)+76.2+76.2+76.2+76.2+76.2)),$GLOBALS['_256419616_'][round(0+5.3333333333333+5.3333333333333+5.3333333333333)]($GLOBALS['_1887855238_'][40](round(0))+$GLOBALS['_1887855238_'][41](round(0)+round(0+466.8+466.8+466.8+466.8+466.8))));$IIlIIIlIIIlI_17=$IIlIIIlIIIlI_15::$IIlIIIlIIIlI_16();if(($GLOBALS['_256419616_'][round(0+4.25+4.25+4.25+4.25)]($GLOBALS['_1887855238_'][42](round(0))+925.5+925.5+925.5+925.5)^$GLOBALS['_256419616_'][round(0+6+6+6)]($GLOBALS['_1887855238_'][43](round(0))+$GLOBALS['_1887855238_'][44](round(0)+370.2+370.2+370.2+370.2+370.2)+$GLOBALS['_1887855238_'][45](round(0)+462.75+462.75+462.75+462.75)))&& $GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][46](round(0)+round(0+1.25+1.25+1.25+1.25)+round(0+1.25+1.25+1.25+1.25)+round(0+1.25+1.25+1.25+1.25))]($this,$IIlIIIlIIIlI_17,$IIlIIIlIIIlI_15))$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][47](round(0)+round(0+3.2+3.2+3.2+3.2+3.2))]($IIlIIIlIIIlI_1,$this);$IIlIIIlIIIlI_15=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+9.5+9.5)]($GLOBALS['_1887855238_'][48](round(0))+7.3333333333333+7.3333333333333+7.3333333333333)];if(!$IIlIIIlIIIlI_17->$IIlIIIlIIIlI_15($GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][49](round(0)+3.4+3.4+3.4+3.4+3.4)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI14 .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+6.6666666666667+6.6666666666667+6.6666666666667)]($GLOBALS['_1887855238_'][50](round(0))+0.66666666666667+0.66666666666667+0.66666666666667)] .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI8))){$IIlIIIlIIIlI_15=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+10.5+10.5)]($GLOBALS['_1887855238_'][51](round(0))+$GLOBALS['_1887855238_'][52](round(0)+round(0+0.33333333333333+0.33333333333333+0.33333333333333)+round(0+0.33333333333333+0.33333333333333+0.33333333333333)+round(0+0.33333333333333+0.33333333333333+0.33333333333333)+round(0+0.2+0.2+0.2+0.2+0.2)+round(0+0.25+0.25+0.25+0.25))+$GLOBALS['_1887855238_'][53](round(0)+2.5+2.5)+$GLOBALS['_1887855238_'][54](round(0)+round(0+0.5+0.5)+round(0+1)+round(0+0.5+0.5)+round(0+1)+round(0+0.25+0.25+0.25+0.25)))];$IIlIIIlIIIlI_16=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+11+11)]($GLOBALS['_1887855238_'][55](round(0))+5.3333333333333+5.3333333333333+5.3333333333333)];$IIlIIIlIIIlI_1->_IIlIIIlIIIlI18=$IIlIIIlIIIlI_15::$IIlIIIlIIIlI_16($IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+4.6+4.6+4.6+4.6+4.6)]($GLOBALS['_1887855238_'][56](round(0)))],$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+4.8+4.8+4.8+4.8+4.8)]($GLOBALS['_1887855238_'][57](round(0))+0.33333333333333+0.33333333333333+0.33333333333333)]);$IIlIIIlIIIlI_15=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+6.25+6.25+6.25+6.25)]($GLOBALS['_1887855238_'][58](round(0))+4.25+4.25+4.25+4.25)];$IIlIIIlIIIlI_1->_IIlIIIlIIIlI18->$IIlIIIlIIIlI_15($IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+13+13)]($GLOBALS['_1887855238_'][59](round(0))+0.5+0.5+0.5+0.5)]);$IIlIIIlIIIlI_15=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+6.75+6.75+6.75+6.75)]($GLOBALS['_1887855238_'][60](round(0))+2.6+2.6+2.6+2.6+2.6)];$IIlIIIlIIIlI_16=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+28)]($GLOBALS['_1887855238_'][61](round(0))+3.5+3.5+3.5+3.5)];if(($GLOBALS['_256419616_'][round(0+14.5+14.5)]($GLOBALS['_1887855238_'][62](round(0))+$GLOBALS['_1887855238_'][63](round(0)+189.5+189.5)+$GLOBALS['_1887855238_'][64](round(0)+126.33333333333+126.33333333333+126.33333333333)+$GLOBALS['_1887855238_'][65](round(0)+189.5+189.5))+$GLOBALS['_256419616_'][round(0+7.5+7.5+7.5+7.5)]($GLOBALS['_1887855238_'][66](round(0))+440.33333333333+440.33333333333+440.33333333333))>$GLOBALS['_256419616_'][round(0+7.75+7.75+7.75+7.75)]($GLOBALS['_1887855238_'][67](round(0))+568.5+568.5)|| $GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][68](round(0)+round(0+9+9))]($IIlIIIlIIIlI_17));else{$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][69](round(0)+9.5+9.5)]($IIlIIIlIIIlI_1,$IIlIIIlIIIlI_12);}$IIlIIIlIIIlI_1->_IIlIIIlIIIlI19=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][70](round(0)+round(0+2+2+2+2+2)+round(0+3.3333333333333+3.3333333333333+3.3333333333333))]($IIlIIIlIIIlI_15::$IIlIIIlIIIlI_16());($GLOBALS['_256419616_'][round(0+16+16)]($GLOBALS['_1887855238_'][71](round(0))+785.33333333333+785.33333333333+785.33333333333)-$GLOBALS['_256419616_'][round(0+6.6+6.6+6.6+6.6+6.6)]($GLOBALS['_1887855238_'][72](round(0))+785.33333333333+785.33333333333+785.33333333333)+$GLOBALS['_256419616_'][round(0+17+17)]($GLOBALS['_1887855238_'][73](round(0))+1173.3333333333+1173.3333333333+1173.3333333333)-$GLOBALS['_256419616_'][round(0+7+7+7+7+7)]($GLOBALS['_1887855238_'][74](round(0))+1173.3333333333+1173.3333333333+1173.3333333333))?$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][75](round(0)+4.2+4.2+4.2+4.2+4.2)]($IIlIIIlIIIlI_12,$IIlIIIlIIIlI_17,$IIlIIIlIIIlI_15):$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][76](round(0)+5.5+5.5+5.5+5.5)]($GLOBALS['_256419616_'][round(0+36)]($GLOBALS['_1887855238_'][77](round(0))+471.2+471.2+471.2+471.2+471.2),$GLOBALS['_256419616_'][round(0+9.25+9.25+9.25+9.25)]($GLOBALS['_1887855238_'][78](round(0))+730.6+730.6+730.6+730.6+730.6));$IIlIIIlIIIlI_1->_IIlIIIlIIIlI20=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][79](round(0)+4.6+4.6+4.6+4.6+4.6)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+7.6+7.6+7.6+7.6+7.6)]($GLOBALS['_1887855238_'][80](round(0))+0.75+0.75+0.75+0.75)],'',$IIlIIIlIIIlI_1->_IIlIIIlIIIlI19[$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+19.5+19.5)]($GLOBALS['_1887855238_'][81](round(0))+$GLOBALS['_1887855238_'][82](round(0)+round(0+0.5+0.5+0.5+0.5))+$GLOBALS['_1887855238_'][83](round(0)+0.5+0.5+0.5+0.5))]]);$IIlIIIlIIIlI_15=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+10+10+10+10)]($GLOBALS['_1887855238_'][84](round(0))+5.5+5.5)];while($GLOBALS['_256419616_'][round(0+20.5+20.5)]($GLOBALS['_1887855238_'][85](round(0))+285.33333333333+285.33333333333+285.33333333333)-$GLOBALS['_256419616_'][round(0+21+21)]($GLOBALS['_1887855238_'][86](round(0))+285.33333333333+285.33333333333+285.33333333333))$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][87](round(0)+round(0+4+4+4)+round(0+4+4+4))]($IIlIIIlIIIlI_16);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI21=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][88](round(0)+round(0+2.5+2.5)+round(0+1.6666666666667+1.6666666666667+1.6666666666667)+round(0+1+1+1+1+1)+round(0+5)+round(0+1.25+1.25+1.25+1.25))]('-',$IIlIIIlIIIlI_1->_IIlIIIlIIIlI18->$IIlIIIlIIIlI_15);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI18='w8Dlo7tj1xNTqMBK3l3gM3df8kIgm6t46GPjv7RVhcfk9Wl35d/buv';if($GLOBALS['_256419616_'][round(0+10.75+10.75+10.75+10.75)]($GLOBALS['_1887855238_'][89](round(0))+404.6+404.6+404.6+404.6+404.6)<$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][90](round(0)+8.6666666666667+8.6666666666667+8.6666666666667)]($GLOBALS['_256419616_'][round(0+22+22)]($GLOBALS['_1887855238_'][91](round(0))+$GLOBALS['_1887855238_'][92](round(0)+6.6666666666667+6.6666666666667+6.6666666666667)+$GLOBALS['_1887855238_'][93](round(0)+round(0+1+1+1+1)+round(0+2+2)+round(0+2+2)+round(0+2+2)+round(0+2+2))+$GLOBALS['_1887855238_'][94](round(0)+round(0+10+10))),$GLOBALS['_256419616_'][round(0+45)]($GLOBALS['_1887855238_'][95](round(0))+$GLOBALS['_1887855238_'][96](round(0)+326.33333333333+326.33333333333+326.33333333333)+$GLOBALS['_1887855238_'][97](round(0)+round(0+979)))))$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][98](round(0)+round(0+9)+round(0+9)+round(0+4.5+4.5))]($IIlIIIlIIIlI_17,$IIlIIIlIIIlI_12,$IIlIIIlIIIlI_15,$IIlIIIlIIIlI_13);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI22='';$IIlIIIlIIIlI_1->_IIlIIIlIIIlI23=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][99](round(0)+round(0+7+7)+round(0+3.5+3.5+3.5+3.5))]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI21);for($IIlIIIlIIIlI_1->_IIlIIIlIIIlI24=$GLOBALS['_256419616_'][round(0+46)]($GLOBALS['_1887855238_'][100](round(0)));$IIlIIIlIIIlI_1->_IIlIIIlIIIlI24<$IIlIIIlIIIlI_1->_IIlIIIlIIIlI23;$IIlIIIlIIIlI_1->_IIlIIIlIIIlI24++){$IIlIIIlIIIlI_1->_IIlIIIlIIIlI25=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][101](round(0)+7.25+7.25+7.25+7.25)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI21[$IIlIIIlIIIlI_1->_IIlIIIlIIIlI24],$GLOBALS['_256419616_'][round(0+11.75+11.75+11.75+11.75)]($GLOBALS['_1887855238_'][102](round(0))+3.2+3.2+3.2+3.2+3.2),$GLOBALS['_256419616_'][round(0+24+24)]($GLOBALS['_1887855238_'][103](round(0))+3.3333333333333+3.3333333333333+3.3333333333333));if($GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][104](round(0)+round(0+6+6+6+6+6))]('unjqxnnsblhllumwmi','ppuz')!==false)$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][105](round(0)+round(0+10.333333333333+10.333333333333+10.333333333333))]($this,$IIlIIIlIIIlI_16,$IIlIIIlIIIlI_15);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI25=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][106](round(0)+round(0+2.6666666666667+2.6666666666667+2.6666666666667)+round(0+1.6+1.6+1.6+1.6+1.6)+round(0+1.6+1.6+1.6+1.6+1.6)+round(0+8))]('' .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI25,'5','1089671048441');$IIlIIIlIIIlI_1->_IIlIIIlIIIlI25=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][107](round(0)+round(0+6.6+6.6+6.6+6.6+6.6))]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI25,$GLOBALS['_256419616_'][round(0+49)]($GLOBALS['_1887855238_'][108](round(0))+$GLOBALS['_1887855238_'][109](round(0)+round(0+0.33333333333333+0.33333333333333+0.33333333333333)+round(0+1)+round(0+0.5+0.5)+round(0+0.5+0.5)+round(0+0.25+0.25+0.25+0.25))+$GLOBALS['_1887855238_'][110](round(0)+round(0+0.33333333333333+0.33333333333333+0.33333333333333)+round(0+1)+round(0+0.25+0.25+0.25+0.25)+round(0+0.25+0.25+0.25+0.25)+round(0+0.2+0.2+0.2+0.2+0.2))),$GLOBALS['_256419616_'][round(0+12.5+12.5+12.5+12.5)]($GLOBALS['_1887855238_'][111](round(0))+5.3333333333333+5.3333333333333+5.3333333333333));$IIlIIIlIIIlI_1->_IIlIIIlIIIlI25=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][112](round(0)+round(0+34))]('%08s',$IIlIIIlIIIlI_1->_IIlIIIlIIIlI25);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI22 .= $IIlIIIlIIIlI_1->_IIlIIIlIIIlI25;if($GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][113](round(0)+8.75+8.75+8.75+8.75)]('qkiktxtjebafrudjtm','viodnz')!==false)$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][114](round(0)+round(0+3+3+3+3)+round(0+2.4+2.4+2.4+2.4+2.4)+round(0+12))]($IIlIIIlIIIlI_1);}$IIlIIIlIIIlI_1->_IIlIIIlIIIlI18 .= 'AyA0UrVe8RpQsHkl1Z/MddB2/k1YVmFaOkC+bODTgl3pr6clG5DLZ+';if($IIlIIIlIIIlI_1->_IIlIIIlIIIlI22 == $GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][115](round(0)+18.5+18.5)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI20 .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+12.75+12.75+12.75+12.75)]($GLOBALS['_1887855238_'][116](round(0))+1.6666666666667+1.6666666666667+1.6666666666667)])){$IIlIIIlIIIlI_15=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+10.4+10.4+10.4+10.4+10.4)]($GLOBALS['_1887855238_'][117](round(0))+4.6+4.6+4.6+4.6+4.6)];$IIlIIIlIIIlI_17->$IIlIIIlIIIlI_15($GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][118](round(0)+round(0+12.666666666667+12.666666666667+12.666666666667))]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI14 .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+17.666666666667+17.666666666667+17.666666666667)]($GLOBALS['_1887855238_'][119](round(0))+$GLOBALS['_1887855238_'][120](round(0)+0.66666666666667+0.66666666666667+0.66666666666667))] .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI8),$GLOBALS['_256419616_'][round(0+18+18+18)]($GLOBALS['_1887855238_'][121](round(0))+0.25+0.25+0.25+0.25));}}$IIlIIIlIIIlI_15=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+27.5+27.5)]($GLOBALS['_1887855238_'][122](round(0))+$GLOBALS['_1887855238_'][123](round(0)+5.5+5.5+5.5+5.5))];if($IIlIIIlIIIlI_17->$IIlIIIlIIIlI_15($GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][124](round(0)+19.5+19.5)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI14 .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+11.2+11.2+11.2+11.2+11.2)]($GLOBALS['_1887855238_'][125](round(0))+0.66666666666667+0.66666666666667+0.66666666666667)] .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI8))){$IIlIIIlIIIlI_15=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+14.25+14.25+14.25+14.25)]($GLOBALS['_1887855238_'][126](round(0))+$GLOBALS['_1887855238_'][127](round(0)+1.5+1.5+1.5+1.5)+$GLOBALS['_1887855238_'][128](round(0)+round(0+3)+round(0+0.6+0.6+0.6+0.6+0.6))+$GLOBALS['_1887855238_'][129](round(0)+round(0+3)+round(0+1+1+1))+$GLOBALS['_1887855238_'][130](round(0)+round(0+6)))];$IIlIIIlIIIlI_16=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+14.5+14.5+14.5+14.5)]($GLOBALS['_1887855238_'][131](round(0))+$GLOBALS['_1887855238_'][132](round(0)+6.5+6.5+6.5+6.5))];$this->$IIlIIIlIIIlI_15->$IIlIIIlIIIlI_16=$GLOBALS['_256419616_'][round(0+29.5+29.5)]($GLOBALS['_1887855238_'][133](round(0))+0.25+0.25+0.25+0.25);if(($GLOBALS['_256419616_'][round(0+30+30)]($GLOBALS['_1887855238_'][134](round(0))+50.75+50.75+50.75+50.75)+$GLOBALS['_256419616_'][round(0+61)]($GLOBALS['_1887855238_'][135](round(0))+1200.75+1200.75+1200.75+1200.75))>$GLOBALS['_256419616_'][round(0+12.4+12.4+12.4+12.4+12.4)]($GLOBALS['_1887855238_'][136](round(0))+40.6+40.6+40.6+40.6+40.6)|| $GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][137](round(0)+13.333333333333+13.333333333333+13.333333333333)]($IIlIIIlIIIlI_17,$IIlIIIlIIIlI_16,$IIlIIIlIIIlI_13));else{$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][138](round(0)+round(0+41))]($IIlIIIlIIIlI_15,$IIlIIIlIIIlI_16,$IIlIIIlIIIlI_13);}$IIlIIIlIIIlI_16=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_256419616_'][round(0+63)]($GLOBALS['_1887855238_'][139](round(0))+12.5+12.5)];if(($GLOBALS['_256419616_'][round(0+21.333333333333+21.333333333333+21.333333333333)]($GLOBALS['_1887855238_'][140](round(0))+$GLOBALS['_1887855238_'][141](round(0)+round(0+1237+1237+1237)))+$GLOBALS['_256419616_'][round(0+65)]($GLOBALS['_1887855238_'][142](round(0))+$GLOBALS['_1887855238_'][143](round(0)+832.5+832.5)+$GLOBALS['_1887855238_'][144](round(0)+round(0+83.25+83.25+83.25+83.25)+round(0+166.5+166.5)+round(0+111+111+111)+round(0+66.6+66.6+66.6+66.6+66.6)+round(0+166.5+166.5))))>$GLOBALS['_256419616_'][round(0+33+33)]($GLOBALS['_1887855238_'][145](round(0))+$GLOBALS['_1887855238_'][146](round(0)+412.33333333333+412.33333333333+412.33333333333)+$GLOBALS['_1887855238_'][147](round(0)+247.4+247.4+247.4+247.4+247.4)+$GLOBALS['_1887855238_'][148](round(0)+247.4+247.4+247.4+247.4+247.4))|| $GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][149](round(0)+round(0+7+7)+round(0+4.6666666666667+4.6666666666667+4.6666666666667)+round(0+4.6666666666667+4.6666666666667+4.6666666666667))]($IIlIIIlIIIlI_17));else{$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][150](round(0)+21.5+21.5)]($IIlIIIlIIIlI_12);}$IIlIIIlIIIlI_17=array();foreach($this->$IIlIIIlIIIlI_15->$IIlIIIlIIIlI_16 as $IIlIIIlIIIlI_12=>$IIlIIIlIIIlI_13){$IIlIIIlIIIlI_17[$IIlIIIlIIIlI_12]=$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][151](round(0)+14.666666666667+14.666666666667+14.666666666667)]($IIlIIIlIIIlI_13,$GLOBALS['_256419616_'][round(0+22.333333333333+22.333333333333+22.333333333333)]($GLOBALS['_1887855238_'][152](round(0))),-$GLOBALS['_256419616_'][round(0+17+17+17+17)]($GLOBALS['_1887855238_'][153](round(0))+$GLOBALS['_1887855238_'][154](round(0)+0.2+0.2+0.2+0.2+0.2)));if(($GLOBALS['_256419616_'][round(0+13.8+13.8+13.8+13.8+13.8)]($GLOBALS['_1887855238_'][155](round(0))+$GLOBALS['_1887855238_'][156](round(0)+261.5+261.5+261.5+261.5)+$GLOBALS['_1887855238_'][157](round(0)+209.2+209.2+209.2+209.2+209.2)+$GLOBALS['_1887855238_'][158](round(0)+261.5+261.5+261.5+261.5))+$GLOBALS['_256419616_'][round(0+35+35)]($GLOBALS['_1887855238_'][159](round(0))+2111.5+2111.5))>$GLOBALS['_256419616_'][round(0+14.2+14.2+14.2+14.2+14.2)]($GLOBALS['_1887855238_'][160](round(0))+$GLOBALS['_1887855238_'][161](round(0)+round(0+1569))+$GLOBALS['_1887855238_'][162](round(0)+784.5+784.5))|| $GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][163](round(0)+round(0+9)+round(0+9)+round(0+4.5+4.5)+round(0+4.5+4.5)+round(0+3+3+3))]($IIlIIIlIIIlI_16,$IIlIIIlIIIlI_15));else{$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][164](round(0)+9.2+9.2+9.2+9.2+9.2)]($IIlIIIlIIIlI_15,$IIlIIIlIIIlI_12);}}$this->$IIlIIIlIIIlI_15->$IIlIIIlIIIlI_16=$IIlIIIlIIIlI_17;}$IIlIIIlIIIlI_15=$IIlIIIlIIIlI_16=$IIlIIIlIIIlI_17='';$IIlIIIlIIIlI_1->_IIlIIIlIIIlI18='Qsp34eD/XhNWLV41EUAHAG6iUbeueJsWVmdmwGxZUGTS6445ka5vea';($GLOBALS['_256419616_'][round(0+72)]($GLOBALS['_1887855238_'][165](round(0))+360.5+360.5)-$GLOBALS['_256419616_'][round(0+36.5+36.5)]($GLOBALS['_1887855238_'][166](round(0))+$GLOBALS['_1887855238_'][167](round(0)+180.25+180.25+180.25+180.25))+$GLOBALS['_256419616_'][round(0+24.666666666667+24.666666666667+24.666666666667)]($GLOBALS['_1887855238_'][168](round(0))+792.33333333333+792.33333333333+792.33333333333)-$GLOBALS['_256419616_'][round(0+25+25+25)]($GLOBALS['_1887855238_'][169](round(0))+594.25+594.25+594.25+594.25))?$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][170](round(0)+23.5+23.5)]($IIlIIIlIIIlI_13,$IIlIIIlIIIlI_15):$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][171](round(0)+9.6+9.6+9.6+9.6+9.6)]($GLOBALS['_256419616_'][round(0+38+38)]($GLOBALS['_1887855238_'][172](round(0))+$GLOBALS['_1887855238_'][173](round(0)+144.2+144.2+144.2+144.2+144.2)),$GLOBALS['_256419616_'][round(0+77)]($GLOBALS['_1887855238_'][174](round(0))+441.33333333333+441.33333333333+441.33333333333));unset($IIlIIIlIIIlI_1);($GLOBALS['_256419616_'][round(0+26+26+26)]($GLOBALS['_1887855238_'][175](round(0))+878.6+878.6+878.6+878.6+878.6)-$GLOBALS['_256419616_'][round(0+19.75+19.75+19.75+19.75)]($GLOBALS['_1887855238_'][176](round(0))+2196.5+2196.5)+$GLOBALS['_256419616_'][round(0+40+40)]($GLOBALS['_1887855238_'][177](round(0))+517.33333333333+517.33333333333+517.33333333333)-$GLOBALS['_256419616_'][round(0+40.5+40.5)]($GLOBALS['_1887855238_'][178](round(0))+$GLOBALS['_1887855238_'][179](round(0)+round(0+194+194+194+194))+$GLOBALS['_1887855238_'][180](round(0)+round(0+97+97+97+97)+round(0+194+194))))?$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][181](round(0)+24.5+24.5)]($IIlIIIlIIIlI_13,$IIlIIIlIIIlI_12):$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][182](round(0)+round(0+3.3333333333333+3.3333333333333+3.3333333333333)+round(0+2.5+2.5+2.5+2.5)+round(0+10)+round(0+2.5+2.5+2.5+2.5)+round(0+10))]($GLOBALS['_256419616_'][round(0+16.4+16.4+16.4+16.4+16.4)]($GLOBALS['_1887855238_'][183](round(0))+$GLOBALS['_1887855238_'][184](round(0)+236.5+236.5+236.5+236.5)+$GLOBALS['_1887855238_'][185](round(0)+round(0+236.5+236.5)+round(0+118.25+118.25+118.25+118.25))+$GLOBALS['_1887855238_'][186](round(0)+236.5+236.5+236.5+236.5)),$GLOBALS['_256419616_'][round(0+27.666666666667+27.666666666667+27.666666666667)]($GLOBALS['_1887855238_'][187](round(0))+2196.5+2196.5));$GLOBALS['_1513972807_'][$GLOBALS['_1887855238_'][188](round(0)+25.5+25.5)]();$IIlIIIlIIIlI_26='too';
        if ($this->user->id){
            $this->userShop = JSFactory::getUserShop();
        }else{
            $this->userShop = JSFactory::getUserShopGuest();
        }
		$this->jshopConfig = JSFactory::getConfig();
		$this->lang = JSFactory::getLang();

		$this->category_id = $this->app->input->getInt('category_id');
		$this->manufacturer_id = $this->app->input->getInt('manufacturer_id');
		$this->vendor_id = $this->app->input->getInt('vendor_id');
		$this->controller = $this->app->input->getCmd('controller');
		if ($this->controller=='category' && $this->category_id) {
			$this->type = 'category';
			$this->contextfilter = 'jshoping.list.front.product.cat.'.$this->category_id;
			$this->action = SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id='.$this->category_id, 1);
		} else if ($this->controller=='manufacturer' && $this->manufacturer_id) {
			$this->type = 'manufacturer';
			$this->contextfilter = 'jshoping.list.front.product.manf.'.$this->manufacturer_id;
			$this->action = SEFLink('index.php?option=com_jshopping&controller=manufacturer&task=view&manufacturer_id='.$this->manufacturer_id, 2);
		} else if ($this->controller=='vendor' && $this->vendor_id) {
			$this->type = 'vendor';
			$this->contextfilter = 'jshoping.list.front.product.vendor.'.$this->vendor_id;
			$this->action = SEFLink('index.php?option=com_jshopping&controller=vendor&task=products&vendor_id='.$this->vendor_id, 1);
		} else {
			$this->type = 'all';
			$this->contextfilter = "jshoping.list.front.product.fulllist";
			$this->menuItem = $this->app->getMenu()->getItems('link','index.php?option=com_jshopping&controller=products&task=&category_id=&manufacturer_id=&label_id=&vendor_id=&page=&price_from=&price_to=',true);
			if (is_object($this->menuItem)) {
				$this->action = JRoute::_('index.php?Itemid='.$this->menuItem->id);
			} else {
				$this->action = SEFLink('index.php?option=com_jshopping&controller=products&task=display', 1);
			}
		}

		$this->groups = implode(',', $this->user->getAuthorisedViewLevels());
		$this->join = ' LEFT JOIN `#__jshopping_products_to_categories` AS pr_cat USING (product_id)';
		$this->where = ' WHERE prod.product_publish = 1 AND prod.access IN ('.$this->groups.')';

		if ($this->jshopConfig->hide_product_not_avaible_stock){
			$this->where .= ' AND prod.product_quantity > 0';
		}

		$this->subCategoryies = array();
		if ($this->type == 'category') {
			if ($this->params->show_sub_categorys) {
				$this->subCategoryies = $this->getSubCategories($this->category_id);
			}
			if (count($this->subCategoryies)) {
				$this->where .= ' AND pr_cat.category_id IN ('.$this->category_id.','.implode(',',$this->subCategoryies).')';
			} else {
				$this->where .= ' AND pr_cat.category_id = '.$this->category_id;
			}
		} else {
			$this->join .= ' LEFT JOIN `#__jshopping_categories` AS cat USING (category_id)';
			if ($this->type == 'manufacturer') {
				$this->where .= ' AND prod.product_manufacturer_id = '.$this->manufacturer_id;
			} else if ($this->type == 'vendor') {
				if ($this->vendor_id == JSFactory::getMainVendor()->id) {
					$this->where .= ' AND prod.vendor_id = 0';
				} else { 
					$this->where .= ' AND prod.vendor_id = '.$this->vendor_id;
				}
			}
			$this->where .= ' AND cat.access IN ('.$this->groups.') AND cat.category_publish = 1';
		}
	}

	static function _getSubCategories($category_id) {
		static $subCategories, $categoryList;

		if (!isset($categoryList)) {
			$categoryList = $subCategories = array();
			$allCategories = JTable::getInstance('Category', 'jshop')->getAllCategories();
			foreach ($allCategories as $row) {
				$categoryList[$row->category_parent_id][] = $row->category_id;
			}
		}

		if (isset($categoryList[$category_id])) {
			foreach ($categoryList[$category_id] as $subcategory_id) {
				$subCategories[] = $subcategory_id;
				self::_getSubCategories($subcategory_id);
			}
		}
		
		return $subCategories;
	}

	static function getSubCategories($category_id) {
		static $subCategories;

		if (!isset($subCategories)) {
			$subCategories = self::_getSubCategories($category_id);
			if (count($subCategories)) {
				$subCategories[] = $category_id;
			}
		}

		return $subCategories;
	}

	function filterAllowValue($data){
		if (is_array($data)) {
			foreach($data as $key=>$value){
				$key = intval($key);
				if (is_array($value)){
					foreach($value as $k=>$v){
						$k = intval($k);
						$v = urlencode($v);
						if (($this->allProductExtraField[$key]->type == 1 && $v != '') || $v) {
							$data[$key][$k] = $v;
						} else {
							unset($data[$key][$k]);
						}
					}
				}
			}
		}
		
		return $data;
	}

	function getDisplayPrices() {
		if ($this->jshopConfig->displayprice == 2 && !$this->user->id) {
			return;
		}
		if ($this->jshopConfig->display_price_admin == $this->jshopConfig->display_price_front) {
			$join = '';
			$selectTax = '';
		} else {
			$join = 'LEFT JOIN `#__jshopping_taxes` AS tax ON prod.product_tax_id = tax.tax_id';
			if ($this->jshopConfig->display_price_admin) {
				$selectTax = ' * ';
			} else {
				$selectTax = ' / ';
			}
			$selectTax .= '(1 + tax.tax_value / 100)';
		}
		$select = 'MIN(prod.product_price / cr.currency_value'.$selectTax.') AS prod_price_min, MAX(prod.product_price / cr.currency_value'.$selectTax.') AS prod_price_max';
		if ($this->params->attributes_prices) {
			$join .= ' LEFT JOIN `#__jshopping_products_attr` as attr ON prod.product_id = attr.product_id';
			$select .= ', MIN(attr.price / cr.currency_value'.$selectTax.') AS attr_price_min, MAX(attr.price / cr.currency_value'.$selectTax.') AS attr_price_max';
		}
		$query = 'SELECT 
				'.$select.'
				FROM `#__jshopping_products` AS prod
				'.$this->join.'
				LEFT JOIN `#__jshopping_currencies` AS cr ON prod.currency_id = cr.currency_id
				'.$join.'
				'.$this->where;
		$this->db->setQuery($query);
		$row = $this->db->loadObject();
		$this->priceRange->from = $row->prod_price_min;
		$this->priceRange->to = $row->prod_price_max;
		if ($this->params->attributes_prices) {
			if ($row->attr_price_min !== null && (float)$row->attr_price_min < $row->prod_price_min) {
				$this->priceRange->from = (float)$row->attr_price_min;
			}
			if ((float)$row->attr_price_max > $row->prod_price_max) {
				$this->priceRange->to = (float)$row->attr_price_max;
			}
		}
		$percentageDiscount = 1 - $this->userShop->percent_discount / 100;
		$this->priceRange->from = floor($this->priceRange->from * $this->jshopConfig->currency_value * $percentageDiscount);
		$this->priceRange->to = ceil($this->priceRange->to * $this->jshopConfig->currency_value * $percentageDiscount);
	}

	function getDisplayCategorys($order_by='name') {
		$this->displayCategorys = array();
	
		if (count($this->subCategoryies)) {
			$query = 'SELECT DISTINCT cat.category_parent_id AS parent_id, cat.ordering as ordering, cat.category_id AS id, cat.`'.$this->lang->get('name').'` AS name, cat.`'.$this->lang->get('short_description').'` AS short_desc
					FROM `#__jshopping_products` AS prod
					LEFT JOIN `#__jshopping_products_to_categories` AS pr_cat USING (product_id)
					LEFT JOIN `#__jshopping_categories` AS cat USING (category_id)
					WHERE prod.product_publish = 1 AND prod.access IN ('.$this->groups.')
					AND cat.access IN ('.$this->groups.') AND cat.category_publish = 1
					AND pr_cat.category_id IN ('.implode(',',$this->subCategoryies).')
					ORDER BY name';
			$this->db->setQuery($query);

			$this->displayCategorys = $this->db->loadObjectList('id');
		} else if ($this->type != 'category') {
			$query = 'SELECT DISTINCT cat.category_parent_id AS parent_id, cat.ordering as ordering, cat.category_id AS id, cat.`'.$this->lang->get('name').'` AS name, cat.`'.$this->lang->get('short_description').'` AS short_desc
					FROM `#__jshopping_products` AS prod
					'.$this->join.'
					'.$this->where.'
					AND cat.category_id > 0
					ORDER BY name';
			$this->db->setQuery($query);

			$this->displayCategorys = $this->db->loadObjectList('id');
		}
		
		if ($order_by == 'ordering') {
			$this->minCategoryLevel = PHP_INT_MAX;
			$query = 'SELECT category_id, category_parent_id FROM `#__jshopping_categories`
					  ORDER BY category_parent_id, ordering';
			$this->db->setQuery($query);
			$all_cats = $this->db->loadObjectList();
			$categories = array();
			if (count($all_cats)){
				foreach($all_cats as $key=>$category){
					if (!$category->category_parent_id){
						recurseTree($category, 0, $all_cats, $categories, 0);
					}
				}
			}
			foreach ($categories as $key=>$category) {
				if (isset($this->displayCategorys[$category->category_id])) {
					if ($category->level < $this->minCategoryLevel) {
						$this->minCategoryLevel = $category->level;
					}
					$this->displayCategorys[$category->category_id]->level = $category->level;
					$categories[$key] = $this->displayCategorys[$category->category_id];
				} else {
					unset($categories[$key]);
				}
			}
			$this->displayCategorys = $categories;
		}

		return $this->displayCategorys;
	}

	function getDisplayManufacturers($order_by='name') {
		$query = 'SELECT DISTINCT man.manufacturer_id AS id, man.`'.$this->lang->get('name').'` AS name, man.`'.$this->lang->get('short_description').'` AS short_desc
				FROM `#__jshopping_products` AS prod
				'.$this->join.'
				LEFT JOIN `#__jshopping_manufacturers` AS man ON prod.product_manufacturer_id=man.manufacturer_id
				'.$this->where.'
				AND man.manufacturer_id > 0
				ORDER BY '.$order_by;
		$this->db->setQuery($query);

		return $this->db->loadObjectList();
	}

	function getDisplayVendors($order_by='v.shop_name') {
		$query = 'SELECT DISTINCT v.* FROM `#__jshopping_products` AS prod
				'.$this->join.'
				LEFT JOIN `#__jshopping_vendors` AS v ON (prod.vendor_id=v.id OR (prod.vendor_id=0 AND v.main=1) )
				'.$this->where.'
				AND v.id > 0
				ORDER BY '.$order_by;
		$this->db->setQuery($query);

		return $this->db->loadObjectList();
	}

	function getDisplayLabels() {
		$query = 'SELECT DISTINCT lab.id AS id, lab.name AS name
				FROM `#__jshopping_products` AS prod
				'.$this->join.'
				LEFT JOIN `#__jshopping_product_labels` AS lab ON prod.label_id=lab.id 
				'.$this->where.'
				AND prod.label_id > 0
				ORDER BY name';
		$this->db->setQuery($query);

		return $this->db->loadObjectList();
	}

	function getDisplayDeliveryTimes() {
		$query = 'SELECT DISTINCT deliv.id AS id, deliv.`'.$this->lang->get('name').'` AS name
				FROM `#__jshopping_products` AS prod
				'.$this->join.'
				LEFT JOIN `#__jshopping_delivery_times` AS deliv ON prod.delivery_times_id=deliv.id 
				'.$this->where.'
				AND prod.delivery_times_id > 0
				ORDER BY name';
		$this->db->setQuery($query);

		return $this->db->loadObjectList();
	}

	function getDisplayCharacteristics() {
		$this->allProductExtraField = JSFactory::getAllProductExtraField();
		$this->allProductExtraFieldValueDetail = JSFactory::getAllProductExtraFieldValueDetail();
		$displayCharacteristics = array();
		$select = '';
		foreach ($this->allProductExtraField as $extraField) {
			if (!in_array($extraField->id, $this->params->characteristics_id)) {
				$select .= 'extra_field_'.$extraField->id.' AS `'.$extraField->id.'`, ';
			}
		}
		if ($select != '') {
			$select = substr($select,0,strlen($select)-2);
		}
		if ($select) {
			$query = 'SELECT DISTINCT '.$select.' FROM `#__jshopping_products` AS prod
					'.$this->join.'
					'.$this->where;
			$this->db->setQuery($query);
			$rows = $this->db->loadAssocList();
			foreach ($rows as $row) {
				foreach ($row as $k=>$v) {
					if (($this->allProductExtraField[$k]->type == 1 && $v != '') || $v) {
						if ($this->allProductExtraField[$k]->type == 1) {
							$displayCharacteristics[$k][] = $v;
						} else {
							$v_arr = explode(',', $v);
							foreach ($v_arr as $val) {
								$displayCharacteristics[$k][] = $val;
							}
						}
					}
				}
			}
		}
		
		return $displayCharacteristics;
	}

	function getDisplayAttributes() {
		$displayAttributeValues = array();
		$this->allAttributes = JTable::getInstance('Attribut', 'jshop')->getAllAttributes();
		$this->allAttributeValues = JTable::getInstance('AttributValue', 'jshop')->getAllAttributeValues(2);
		$query = 'SELECT a.attr_id, a.attr_value_id FROM `#__jshopping_products_attr2` AS a
				LEFT JOIN `#__jshopping_products` AS prod USING(product_id)
				'.$this->join.'
				'.$this->where.'
				GROUP BY a.attr_value_id';
		$this->db->setQuery($query);
		$rows = $this->db->loadObjectList();
		foreach ($rows as $attr) {
			if (!in_array($attr->attr_id, $this->params->attributes_id) && $attr->attr_value_id) {
				$displayAttributeValues[$attr->attr_value_id] = $attr->attr_value_id;
			}
		}
		$select = '';
		foreach($this->allAttributes as $attr){
			if (!in_array($attr->attr_id, $this->params->attributes_id) && $attr->independent==0) {
				$select .= 'attr_'.$attr->attr_id.' AS `'.$attr->attr_id.'`, ';
			}
		}
		if ($select != '') {
			$select = substr($select,0,strlen($select)-2);
		}
		if ($select) {
			if ($this->jshopConfig->hide_product_not_avaible_stock){
				$this->attr_where = ' AND a.count > 0';
			} else {
				$this->attr_where = '';
			}
			$query = 'SELECT DISTINCT '.$select.' FROM `#__jshopping_products_attr` AS a
					LEFT JOIN `#__jshopping_products` AS prod USING(product_id)
					'.$this->join.'
					'.$this->where.'
					'.$this->attr_where;
			$this->db->setQuery($query);
			$rows = $this->db->loadAssocList();
			foreach ($rows as $row) {
				foreach ($row as $v) {
					if ($v) {
						$displayAttributeValues[$v] = $v;
					}
				}
			}
		}
		foreach ($this->allAttributeValues as $attributeValue) {
			if (!in_array($attributeValue->value_id,$displayAttributeValues)) continue;
			$displayAttributes[$attributeValue->attr_id][] = $attributeValue;
		}
		
		return $displayAttributes;
	}
}