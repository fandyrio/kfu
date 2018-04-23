<?php
//$mode="UAT";
$mode="TRAINING";

if($mode=="DEVELOPMENT")
{
	define("API_RESERVE", "https://omnichannel-dev.peentar.xyz/clinic/v1/reservations/");	
	define("API_BPJS", "http://healthplatform.bvk.co.id:8098/api/get_bpsj_peserta_by_nopeserta");
	define("API_DOCTOR", "https://omnichannel-dev.peentar.xyz/clinic/v1/doctors/");
	define("API_POST_PATIEN", "https://omnichannel-dev.peentar.xyz/clinic/v1/patients");
	define("API_POST_PHR", "https://omnichannel-dev.peentar.xyz/clinic/v1/medicalrecords");
}
else if($mode=="GR")
{
	define("API_RESERVE", "https://omnichannel-gladiresik.peentar.id/clinic/v1/reservations/");	
	define("API_BPJS", "http://healthplatform.bvk.co.id:8098/api/apiBPJSPeserta");
	define("API_DOCTOR", "https://omnichannel-gladiresik.peentar.id/clinic/v1/doctors/");
	define("API_POST_PATIEN", "https://omnichannel-gladiresik.peentar.id/clinic/v1/patients");
	define("API_POST_PHR", "https://omnichannel-gladiresik.peentar.id/clinic/v1/medicalrecords");
	define("API_GET_ALL_RESERVE", "https://omnichannel-gladiresik.peentar.id/clinic/v1/reservations/sync");
}
else if($mode=="UAT")
{
	define("API_RESERVE", "https://omnichannel-uat.peentar.id/clinic/v1/reservations/");	
	define("API_BPJS", "http://healthplatform.bvk.co.id:8098/api/apiBPJSPeserta");
	define("API_DOCTOR", "https://omnichannel-uat.peentar.id/clinic/v1/doctors/");
	define("API_POST_PATIEN", "https://omnichannel-uat.peentar.id/clinic/v1/patients");
	define("API_POST_PHR", "https://omnichannel-uat.peentar.id/clinic/v1/medicalrecords");
	define("API_GET_ALL_RESERVE", "https://omnichannel-uat.peentar.id/clinic/v1/reservations/sync");
	define("API_POST_RESEP", "https://omnichannel-uat.peentar.id/clinic/v1/prescription");
	define("API_POST_TINDAKAN", "https://omnichannel-uat.peentar.id/clinic/v1/medical-services");
	define("API_GET_LIST_LAB", "http://202.72.206.42/kfd_test/rest_api/list_klinik.php");
	define("API_SMS", "https://omnichannel-uat.peentar.id/clinic/v1/prolanis/send-sms");

	define("API_GET_OBAT", "https://omnichannel-uat.peentar.id/clinic/v1/items/sync");
	define("API_DETAIL_OBAT", "https://omnichannel-uat.peentar.id/clinic/v1/items/");

	define("API_CEK_STOK", "https://omnichannel-uat.peentar.id/clinic/v1/outlet-inventories/by-item/");
	define("API_GET_PENJAMIN", "https://omnichannel-uat.peentar.id/clinic/v1/insurers/sync");
	define("API_GET_DETAIL_PENJAMIN", "https://omnichannel-uat.peentar.id/clinic/v1/insurers");

}
else if($mode=="PRODUCTION")
{
	define("API_RESERVE", "https://Omnichannel.peentar.id/clinic/v1/reservations/");	
	define("API_BPJS", "http://healthplatform.bvk.co.id:8098/api/apiBPJSPeserta");
	define("API_DOCTOR", "https://Omnichannel.peentar.id/clinic/v1/doctors/");
	define("API_POST_PATIEN", "https://Omnichannel.peentar.id/clinic/v1/patients");
	define("API_POST_PHR", "https://omnichannel.peentar.id/clinic/v1/medicalrecords");
	define("API_GET_ALL_RESERVE", "https://omnichannel.peentar.id/clinic/v1/reservations/sync");
	define("API_POST_RESEP", "https://omnichannel.peentar.id/clinic/v1/prescription");
	define("API_POST_TINDAKAN", "https://omnichannel.peentar.id/clinic/v1/medical-services");
	define("API_GET_LIST_LAB", "http://202.72.206.42/kfd_test/rest_api/list_klinik.php");
	define("API_SMS", "https://omnichannel.peentar.id/clinic/v1/prolanis/send-sms");
	define("API_GET_OBAT", "https://omnichannel.peentar.id/clinic/v1/items/sync");
	define("API_DETAIL_OBAT", "https://omnichannel.peentar.id/clinic/v1/items/");
	define("API_CEK_STOK", "https://omnichannel.peentar.id/clinic/v1/outlet-inventories/by-item/");
	define("API_GET_PENJAMIN", "https://omnichannel.peentar.id/clinic/v1/insurers/sync");
	define("API_GET_DETAIL_PENJAMIN", "https://omnichannel.peentar.id/clinic/v1/insurers");

}
else if($mode=="TRAINING")
{
	define("API_RESERVE", "https://omnichannel-uat.peentar.id/clinic/v1/reservations/");	
	define("API_BPJS", "http://healthplatform.bvk.co.id:8098/api/apiBPJSPeserta");
	define("API_DOCTOR", "https://Omnichannel.peentar.id/clinic/v1/doctors/");
	define("API_POST_PATIEN", "https://Omnichannel.peentar.id/clinic/v1/patients");
	define("API_POST_PHR", "https://omnichannel.peentar.id/clinic/v1/medicalrecords");
	define("API_GET_ALL_RESERVE", "https://omnichannel-uat.peentar.id/clinic/v1/reservations/sync?since=");
	define("API_POST_RESEP", "https://omnichannel-uat.peentar.id/clinic/v1/prescription");
	define("API_POST_TINDAKAN", "https://omnichannel-uat.peentar.id/clinic/v1/medical-services");
	define("API_GET_LIST_LAB", "http://202.72.206.42/kfd_test/rest_api/list_klinik.php");
	define("API_SMS", "https://omnichannel.peentar.id/clinic/v1/prolanis/send-sms");
	define("API_GET_OBAT", "https://omnichannel.peentar.id/clinic/v1/items/sync");
	define("API_DETAIL_OBAT", "https://omnichannel.peentar.id/clinic/v1/items/");
	define("API_CEK_STOK", "https://omnichannel.peentar.id/clinic/v1/outlet-inventories/by-item/");
	define("API_GET_PENJAMIN", "https://omnichannel-uat.peentar.id/clinic/v1/insurers/sync");
	define("API_GET_DETAIL_PENJAMIN", "https://omnichannel-uat.peentar.id/clinic/v1/insurers");
}
else
{
	define("API_RESERVE", "");	
	define("API_BPJS", "http://healthplatform.bvk.co.id:8107/api/get_bpsj_peserta_by_nopeserta");
	define("API_BPJS", "https://omnichannel-dev.peentar.xyz/clinic/v1/doctors");
}



?>