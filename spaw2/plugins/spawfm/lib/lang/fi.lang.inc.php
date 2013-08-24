<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
// Finnish language file
// ================================================
// Developed: Saulius Okunevicius, saulius@solmetra.com
// Copyright: Solmetra (c)2006 All rights reserved.
// Translation: Teemu Joensuu, teemu.joensuu@saunalahti.fi
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2007-06-27
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'iso-8859-1';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'spawfm' => array(
    'title' => 'Tiedostoselain',
    'error_reading_dir' => 'Virhe: Hakemiston sisältöä ei voitu lukea.',
    'error_upload_forbidden' => 'Virhe: Tiedoston lähetys palvelimelle ei ole sallittua tässä hakemistossa.',
    'error_upload_file_too_big' => 'Lataus epäonnistui: tiedostokoko liian iso.',
    'error_upload_failed' => 'Tiedoston lähetys epäonnistui.',
    'error_upload_file_incomplete' => 'Lähetetty tiedosto ei latautunut kokonaan, yritä uudelleen.',
    'error_bad_filetype' => 'Virhe: Tämän tyyppiset tiedostot eivät ole sallittuja.',
    'error_max_filesize' => 'Suurin hyväksytty tiedostokoko:',
    'error_delete_forbidden' => 'Virhe: Tiedostojen poistaminen ei ole sallittua tässä hakemistossa.',
    'confirm_delete' => 'Haluatko varmasti poistaa tiedoston "[*file*]"?',
    'error_delete_failed' => 'Virhe: Tiedostoa ei voitu poistaa. Sinulla ei ole ehkä siihen tarvittavia oikeuksia.',
    'error_no_directory_available' => 'Ei selattavissa olevia hakemistoja.',
    'download_file' => '[lataa tiedosto koneellesi]',
    'error_chmod_uploaded_file' => 'Tiedoston lataus onnistui, mutta oikeuksien muuttaminen epäonnistui.',
    'error_img_width_max' => 'Suurin hyväksytty kuvan leveys: [*MAXWIDTH*] kuvapistettä',
    'error_img_height_max' => 'Suurin hyväksytty kuvan korkeus: [*MAXHEIGHT*] kuvapistettä',
    'rename_text' => 'Anna uusi nimi tiedostolle "[*FILE*]":',
    'error_rename_file_missing' => 'Uudelleen nimeäminen epäonnistui - tiedostoa ei löydetty.',
    'error_rename_directories_forbidden' => 'Virhe: hakemiston uudelleen nimeäminen ei ole sallittua tässä hakemistossa.',
    'error_rename_forbidden' => 'Virhe: Tiedostojen uudelleen nimeäminen ei ole sallittua tässä hakemistossa.',
    'error_rename_file_exists' => 'Virhe: Tiedosto "[*FILE*]" on jo olemassa.',
    'error_rename_failed' => 'Virhe: uudelleen nimeäminen epäonnistui. Sinulla ei ehkä ole tarvittavia oikeuksia.',
    'error_rename_extension_changed' => 'Virhe: Tiedostopäätteen vaihtaminen estetty!',
    'newdirectory_text' => 'Anna uuden hakemiston nimi:',
    'error_create_directories_forbidden' => 'Virhe: hakemistojen luonti on estetty.',
    'error_create_directories_name_used' => 'Antamasi nimi on jo käytössä, kokeile toista nimeä.',
    'error_create_directories_failed' => 'Virhe: Hakemistoa ei voitu luoda. Sinulla ei ehkä ole siihen tarvittavia oikeuksia.',
    'error_create_directories_name_invalid' => 'Seuraavia merkkejä ei voi käyttää hakemiston nimessä: / \\ : * ? " < > ',
    'confirmdeletedir_text' => 'Haluatko varmasti poistaa hakemiston "[*DIR*]"?',
    'error_delete_subdirectories_forbidden' => 'Hakemistojen poistaminen on estetty.',
    'error_delete_subdirectories_failed' => 'Hakemiston poistaminen ei onnistunut. Sinulla ei ehkä ole siihen tarvittavia oikeuksia.',
    'error_delete_subdirectories_not_empty' => 'Hakemisto ei ole tyhjä',
    'upload_if_load_jpg_resize_to' => 'Lähettäessäni jpg-valokuvan pienennä se kokoon',
  ),
  'buttons' => array(
    'ok'        => '  OK  ',
    'cancel'    => 'Peruuta',
    'view_list' => 'Selaustapa: luettelo',
    'view_details' => 'Selaustapa: luettelo ja tiedot',
    'view_thumbs' => 'View mode: esikatselukuvat',
    'rename'    => 'Nimeä uudelleen...',
    'delete'    => 'Poista',
    'go_up'     => 'Ylös',
    'upload'    =>  'Lähetä tiedosto',
    'create_directory'  =>  'Uusi hakemisto...',
  ),
  'file_details' => array(
    'name'  =>  'Nimi',
    'type'  =>  'Tyyppi',
    'size'  =>  'Koko',
    'date'  =>  'Muokattu',
    'filetype_suffix'  =>  'file',
    'img_dimensions'  =>  'Mitat',
    'file_folder'  =>  'Tiedostokansio',
  ),
  'filetypes' => array(
    'any'       => 'Kaikki tiedostot (*.*)',
    'images'    => 'Kuvatiedostot',
    'flash'     => 'Flash-animaatiot',
    'documents' => 'Dokumentit',
    'audio'     => 'Äänitiedostot',
    'video'     => 'Videotiedostot',
    'archives'  => 'Arkistotiedostot',
    '.jpg'  =>  'JPG-kuvatiedosto',
    '.jpeg'  =>  'JPG-kuvatiedosto',
    '.gif'  =>  'GIF-kuvatiedosto',
    '.png'  =>  'PNG-kuvatiedosto',
    '.swf'  =>  'Flash-animaaito',
    '.doc'  =>  'Microsoft Word dokumentti',
    '.xls'  =>  'Microsoft Excel dokumentti',
    '.pdf'  =>  'PDF dokumentti',
    '.rtf'  =>  'RTF dokumentti',
    '.odt'  =>  'OpenDocument Teksti',
    '.ods'  =>  'OpenDocument Taulukkolaskenta',
    '.sxw'  =>  'OpenOffice.org 1.0 Tekstidokumentti',
    '.sxc'  =>  'OpenOffice.org 1.0 Taulukkolaskenta',
    '.wav'  =>  'WAV-audiotiedosto',
    '.mp3'  =>  'MP3-audiotiedosto',
    '.ogg'  =>  'Ogg Vorbis -audiotiedosto',
    '.wma'  =>  'Windows äänitiedosto',
    '.avi'  =>  'AVI-videotiedosto',
    '.mpg'  =>  'MPEG-videotiedosto',
    '.mpeg'  =>  'MPEG-videotiedosto',
    '.mov'  =>  'QuickTime-videotiedosto',
    '.wmv'  =>  'Windows-videotiedosto',
    '.zip'  =>  'ZIP-paketti',
    '.rar'  =>  'RAR-paketti',
    '.gz'  =>  'gzip-paketti',
    '.txt'  =>  'Tekstitiedosto',
    ''  =>  '',
  ),
);
?>
