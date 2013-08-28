<?php

class Whois{
    var $domain;
    var $tldname;
    var $domainname;

    var $servers = array(
        "com"		=>  array("whois.verisign-grs.com","whois.crsnic.net"),
		"net"		=>  array("whois.verisign-grs.com","whois.crsnic.net"),
		"org"		=>  array("whois.pir.org","whois.publicinterestregistry.net"),
		"info"		=>  array("whois.afilias.info","whois.afilias.net"),
		"biz"		=>  array("whois.neulevel.biz"),
		"us"		=>  array("whois.nic.us"),
		"uk"		=>  array("whois.nic.uk"),
		"ca"		=>  array("whois.cira.ca"),
		"tel"		=>  array("whois.nic.tel"),
		"ie"		=>  array("whois.iedr.ie","whois.domainregistry.ie"),
		"it"		=>  array("whois.nic.it"),
		"li"		=>  array("whois.nic.li"),
		"no"		=>  array("whois.norid.no"),
		"cc"		=>  array("whois.nic.cc"),
		"eu"		=>  array("whois.eu"),
		"nu"		=>  array("whois.nic.nu"),
		"au"		=>  array("whois.aunic.net","whois.ausregistry.net.au"),
		"de"		=>  array("whois.denic.de"),
		"ws"		=>  array("whois.worldsite.ws","whois.nic.ws","www.nic.ws"),
		"sc"		=>  array("whois2.afilias-grs.net"),
		"mobi"		=>  array("whois.dotmobiregistry.net"),
		"pro"		=>  array("whois.registrypro.pro","whois.registry.pro"),
		"edu"		=>  array("whois.educause.net","whois.crsnic.net"),
		"tv"		=>  array("whois.nic.tv","tvwhois.verisign-grs.com"),
		"travel"	=>  array("whois.nic.travel"),
		"name"		=>  array("whois.nic.name"),
		"in"		=>  array("whois.inregistry.net","whois.registry.in"),
		"me"		=>  array("whois.nic.me","whois.meregistry.net"),
		"at"		=>  array("whois.nic.at"),
		"be"		=>  array("whois.dns.be"),
		"cn"		=>  array("whois.cnnic.cn","whois.cnnic.net.cn"),
		"asia"		=>  array("whois.nic.asia"),
		"ru"		=>  array("whois.ripn.ru","whois.ripn.net"),
		"ro"		=>  array("whois.rotld.ro"),
		"aero"		=>  array("whois.aero"),
		"fr"		=>  array("whois.nic.fr"),
		"se"		=>  array("whois.iis.se","whois.nic-se.se","whois.nic.se"),
		"nl"		=>  array("whois.sidn.nl","whois.domain-registry.nl"),
		"nz"		=>  array("whois.srs.net.nz","whois.domainz.net.nz"),
		"mx"		=>  array("whois.nic.mx"),
		"tw"		=>  array("whois.apnic.net","whois.twnic.net.tw"),
		"ch"		=>  array("whois.nic.ch"),
		"hk"		=>  array("whois.hknic.net.hk"),
		"ac"		=>  array("whois.nic.ac"),
		"ae"		=>  array("whois.nic.ae"),
		"af"		=>  array("whois.nic.af"),
		"ag"		=>  array("whois.nic.ag"),
		"al"		=>  array("whois.ripe.net"),
		"am"		=>  array("whois.amnic.net"),
		"as"		=>  array("whois.nic.as"),
		"az"		=>  array("whois.ripe.net"),
		"ba"		=>  array("whois.ripe.net"),
		"bg"		=>  array("whois.register.bg"),
		"bi"		=>  array("whois.nic.bi"),
		"bj"		=>  array("www.nic.bj"),
		"br"		=>  array("whois.nic.br"),
		"bt"		=>  array("whois.netnames.net"),
		"by"		=>  array("whois.ripe.net"),
		"bz"		=>  array("whois.belizenic.bz"),
		"cd"		=>  array("whois.nic.cd"),
		"ck"		=>  array("whois.nic.ck"),
		"cl"		=>  array("nic.cl"),
		"coop"		=>  array("whois.nic.coop"),
		"cx"		=>  array("whois.nic.cx"),
		"cy"		=>  array("whois.ripe.net"),
		"cz"		=>  array("whois.nic.cz"),
		"dk"		=>  array("whois.dk-hostmaster.dk"),
		"dm"		=>  array("whois.nic.cx"),
		"dz"		=>  array("whois.ripe.net"),
		"ee"		=>  array("whois.eenet.ee"),
		"eg"		=>  array("whois.ripe.net"),
		"es"		=>  array("whois.ripe.net"),
		"fi"		=>  array("whois.ficora.fi"),
		"fo"		=>  array("whois.ripe.net"),
		"gb"		=>  array("whois.ripe.net"),
		"ge"		=>  array("whois.ripe.net"),
		"gl"		=>  array("whois.ripe.net"),
		"gm"		=>  array("whois.ripe.net"),
		"gov"		=>  array("whois.nic.gov"),
		"gr"		=>  array("whois.ripe.net"),
		"gs"		=>  array("whois.adamsnames.tc"),
		"hm"		=>  array("whois.registry.hm"),
		"hn"		=>  array("whois2.afilias-grs.net"),
		"hr"		=>  array("whois.ripe.net"),
		"hu"		=>  array("whois.ripe.net"),
		"il"		=>  array("whois.isoc.org.il"),
		"int"		=>  array("whois.isi.edu"),
		"iq"		=>  array("vrx.net"),
		"ir"		=>  array("whois.nic.ir"),
		"is"		=>  array("whois.isnic.is"),
		"je"		=>  array("whois.je"),
		"jp"		=>  array("whois.jprs.jp"),
		"kg"		=>  array("whois.domain.kg"),
		"kr"		=>  array("whois.nic.or.kr"),
		"la"		=>  array("whois2.afilias-grs.net"),
		"lt"		=>  array("whois.domreg.lt"),
		"lu"		=>  array("whois.restena.lu"),
		"lv"		=>  array("whois.nic.lv"),
		"ly"		=>  array("whois.lydomains.com"),
		"ma"		=>  array("whois.iam.net.ma"),
		"mc"		=>  array("whois.ripe.net"),
		"md"		=>  array("whois.nic.md"),
		"mil"		=>  array("whois.nic.mil"),
		"mk"		=>  array("whois.ripe.net"),
		"ms"		=>  array("whois.nic.ms"),
		"mt"		=>  array("whois.ripe.net"),
		"mu"		=>  array("whois.nic.mu"),
		"my"		=>  array("whois.mynic.net.my"),
		"nf"		=>  array("whois.nic.cx"),
		"pl"		=>  array("whois.dns.pl"),
		"pr"		=>  array("whois.nic.pr"),
		"pt"		=>  array("whois.dns.pt"),
		"sa"		=>  array("saudinic.net.sa"),
		"sb"		=>  array("whois.nic.net.sb"),
		"sg"		=>  array("whois.nic.net.sg"),
		"sh"		=>  array("whois.nic.sh"),
		"si"		=>  array("whois.arnes.si"),
		"sk"		=>  array("whois.sk-nic.sk"),
		"sm"		=>  array("whois.ripe.net"),
		"st"		=>  array("whois.nic.st"),
		"su"		=>  array("whois.ripn.net"),
		"tc"		=>  array("whois.adamsnames.tc"),
		"tf"		=>  array("whois.nic.tf"),
		"th"		=>  array("whois.thnic.net"),
		"tj"		=>  array("whois.nic.tj"),
		"tk"		=>  array("whois.nic.tk"),
		"tl"		=>  array("whois.domains.tl"),
		"tm"		=>  array("whois.nic.tm"),
		"tn"		=>  array("whois.ripe.net"),
		"to"		=>  array("whois.tonic.to"),
		"tp"		=>  array("whois.domains.tl"),
		"tr"		=>  array("whois.nic.tr"),
		"ua"		=>  array("whois.ripe.net"),
		"uy"		=>  array("nic.uy"),
		"uz"		=>  array("whois.cctld.uz"),
		"va"		=>  array("whois.ripe.net"),
		"vc"		=>  array("whois2.afilias-grs.net"),
		"ve"		=>  array("whois.nic.ve"),
		"vg"		=>  array("whois.adamsnames.tc"),
		"yu"		=>  array("whois.ripe.net")
    );


    function whois($domain_name) {
        $this->domain = $domain_name;
        $this->get_tld();
        $this->get_domain();
    }
	
	function get_whois_info( $domain ){
		$servers = array(
        	array("ac","whois.nic.ac","No match"),
			array("ac.cn","whois.cnnic.net.cn","No entries found"),
			array("ac.jp","whois.nic.ad.jp","No match"),
			array("ac.uk","whois.ja.net","no entries"),
			array("ad.jp","whois.nic.ad.jp","No match"),
			array("adm.br","whois.nic.br","No match"),
			array("adv.br","whois.nic.br","No match"),
			array("aero","whois.information.aero","is available"),
			array("ag","whois.nic.ag","does not exist"),
			array("agr.br","whois.nic.br","No match"),
			array("ah.cn","whois.cnnic.net.cn","No entries found"),
			array("al","whois.ripe.net","No entries found"),
			array("am.br","whois.nic.br","No match"),
			array("arq.br","whois.nic.br","No match"),
			array("at","whois.nic.at","nothing found"),
			array("au","whois.aunic.net","No Data Found"),
			array("art.br","whois.nic.br","No match"),
			array("as","whois.nic.as","Domain Not Found"),
			array("asn.au","whois.aunic.net","No Data Found"),
			array("ato.br","whois.nic.br","No match"),
			array("be","whois.geektools.com","No such domain"),
			array("bg","whois.digsys.bg","does not exist"),
			array("bio.br","whois.nic.br","No match"),
			array("biz","whois.biz","Not found"),
			array("bj.cn","whois.cnnic.net.cn","No entries found"),
			array("bmd.br","whois.nic.br","No match"),
			array("br","whois.registro.br","No match"),
			array("ca","whois.cira.ca","AVAIL"),
			array("cc","whois.nic.cc","No match"),
			array("cd","whois.cd","No match"),
			array("ch","whois.nic.ch","We do not have an entry"),
			array("cim.br","whois.nic.br","No match"),
			array("ck","whois.ck-nic.org.ck","No entries found"),
			array("cl","whois.nic.cl","no existe"),
			array("cn","whois.cnnic.net.cn","no matching record"),
			array("cng.br","whois.nic.br","No match"),
			array("cnt.br","whois.nic.br","No match"),
			array("com","whois.verisign-grs.net","No match"),
			array("com.au","whois.aunic.net","No Data Found"),
			array("com.br","whois.nic.br","No match"),
			array("com.cn","whois.cnnic.net.cn","no matching record"),
			array("com.eg","whois.ripe.net","No entries found"),
			array("com.hk","whois.hknic.net.hk","No Match for"),
			array("com.mx","whois.nic.mx","No Encontradas"),
			array("com.ru","whois.ripn.ru","No entries found"),
			array("com.tw","whois.twnic.net","NO MATCH TIP"),
			array("conf.au","whois.aunic.net","No entries found"),
			array("co.jp","whois.nic.ad.jp","No match"),
			array("co.uk","whois.nic.uk","No match for"),
			array("cq.cn","whois.cnnic.net.cn","No entries found"),
			array("csiro.au","whois.aunic.net","No Data Found"),
			array("cx","whois.nic.cx","No match"),
			array("cz","whois.nic.cz","No data found"),
			array("de","whois.denic.de","No entries found"),
			array("dk","whois.dk-hostmaster.dk","No entries found"),
			array("ecn.br","whois.nic.br","No match"),
			array("ee","whois.eenet.ee","NOT FOUND"),
			array("edu","whois.verisign-grs.net","No match"),
			array("edu.au","whois.aunic.net","No Data Found"),
			array("edu.br","whois.nic.br","No match"),
			array("eg","whois.ripe.net","No entries found"),
			array("es","whois.ripe.net","No entries found"),
			array("esp.br","whois.nic.br","No match"),
			array("etc.br","whois.nic.br","No match"),
			array("eti.br","whois.nic.br","No match"),
			array("eun.eg","whois.ripe.net","No entries found"),
			array("emu.id.au","whois.aunic.net","No Data Found"),
			array("eng.br","whois.nic.br","No match"),
			array("far.br","whois.nic.br","No match"),
			array("fi","whois.ripe.net","No entries found"),
			array("fj","whois.usp.ac.fj",""),
			array("fj.cn","whois.cnnic.net.cn","No entries found"),
			array("fm.br","whois.nic.br","No match"),
			array("fnd.br","whois.nic.br","No match"),
			array("fot.br","whois.nic.br","No match"),
			array("fst.br","whois.nic.br","No match"),
			array("fr","whois.nic.fr","No entries found"),
			array("g12.br","whois.nic.br","No match"),
			array("gd.cn","whois.cnnic.net.cn","No entries found"),
			array("ge","whois.ripe.net","no entries found"),
			array("ggf.br","whois.nic.br","No match"),
			array("gl","whois.ripe.net","no entries found"),
			array("gr","whois.ripe.net","no entries found"),
			array("gr.jp","whois.nic.ad.jp","No match"),
			array("gs","whois.adamsnames.tc","is not registered"),
			array("gov","whois.nic.gov","No entries found"),
			array("gs.cn","whois.cnnic.net.cn","No entries found"),
			array("gov.au","whois.aunic.net","No Data Found"),
			array("gov.br","whois.nic.br","No match"),
			array("gov.cn","whois.cnnic.net.cn","No entries found"),
			array("gov.hk","whois.hknic.net.hk","No Match for"),
			array("gob.mx","whois.nic.mx","No Encontradas"),
			array("gs","whois.adamsnames.tc","is not registered"),
			array("gz.cn","whois.cnnic.net.cn","No entries found"),
			array("gx.cn","whois.cnnic.net.cn","No entries found"),
			array("he.cn","whois.cnnic.net.cn","No entries found"),
			array("ha.cn","whois.cnnic.net.cn","No entries found"),
			array("hb.cn","whois.cnnic.net.cn","No entries found"),
			array("hi.cn","whois.cnnic.net.cn","No entries found"),
			array("hl.cn","whois.cnnic.net.cn","No entries found"),
			array("hn.cn","whois.cnnic.net.cn","No entries found"),
			array("hm","whois.registry.hm","(null)"),
			array("hk","whois.hknic.net.hk","No Match for"),
			array("hk.cn","whois.cnnic.net.cn","No entries found"),
			array("hu","whois.ripe.net","MAXCHARS:500"),
			array("id.au","whois.aunic.net","No Data Found"),
			array("ie","whois.domainregistry.ie","no match"),
			array("ind.br","whois.nic.br","No match"),
			array("imb.br","whois.nic.br","No match"),
			array("inf.br","whois.nic.br","No match"),
			array("info","whois.afilias.info","Not found"),
			array("info.au","whois.aunic.net","No Data Found"),
			array("it","whois.nic.it","No entries found"),
			array("idv.tw","whois.twnic.net","NO MATCH TIP"),
			array("int","whois.iana.org","not found"),
			array("is","whois.isnic.is","No entries found"),
			array("il","whois.isoc.org.il","No data was found"),
			array("jl.cn","whois.cnnic.net.cn","No entries found"),
			array("jor.br","whois.nic.br","No match"),
			array("jp","whois.nic.ad.jp","No match"),
			array("js.cn","whois.cnnic.net.cn","No entries found"),
			array("jx.cn","whois.cnnic.net.cn","No entries found"),
			array("kr","whois.krnic.net","is not registered"),
			array("la","whois.nic.la","NO MATCH"),
			array("lel.br","whois.nic.br","No match"),
			array("li","whois.nic.ch","We do not have an entry"),
			array("lk","whois.nic.lk","No domain registered"),
			array("ln.cn","whois.cnnic.net.cn","No entries found"),
			array("lt","ns.litnet.lt","No matches found"),
			array("lu","whois.dns.lu","No entries found"),
			array("lv","whois.ripe.net","no entries found"),
			array("ltd.uk","whois.nic.uk","No match for"),
			array("mat.br","whois.nic.br","No match"),
			array("mc","whois.ripe.net","No entries found"),
			array("me.uk","whois.nic.uk","No match for"),
			array("med.br","whois.nic.br","No match"),
			array("mil","whois.nic.mil","No match"),
			array("mil.br","whois.nic.br","No match"),
			array("mn","whois.nic.mn","Domain not found"),
			array("mo.cn","whois.cnnic.net.cn","No entries found"),
			array("ms","whois.adamsnames.tc","is not registered"),
			array("mus.br","whois.nic.br","No match"),
			array("mx","whois.nic.mx","No Encontradas"),
			array("name","whois.nic.name","No match."),
			array("ne.jp","whois.nic.ad.jp","No match"),
			array("net","whois.verisign-grs.net","No match"),
			array("net.au","whois.aunic.net","No Data Found"),
			array("net.br","whois.nic.br","No match"),
			array("net.cn","whois.cnnic.net.cn","No entries found"),
			array("net.eg","whois.ripe.net","No entries found"),
			array("net.hk","whois.hknic.net.hk","No Match for"),
			array("net.lu","whois.dns.lu","No entries found"),
			array("net.mx","whois.nic.mx","No Encontradas"),
			array("net.uk","whois.nic.uk","No match for "),
			array("net.ru","whois.ripn.ru","No entries found"),
			array("net.tw","whois.twnic.net","NO MATCH TIP"),
			array("nl","whois.domain-registry.nl","is not a registered domain"),
			array("nm.cn","whois.cnnic.net.cn","No entries found"),
			array("no","whois.norid.no","no matches"),
			array("nom.br","whois.nic.br","No match"),
			array("not.br","whois.nic.br","No match"),
			array("ntr.br","whois.nic.br","No match"),
			array("nu","whois.nic.nu","NO MATCH for"),
			array("nx.cn","whois.cnnic.net.cn","No entries found"),
			array("nz","whois.domainz.net.nz","220 Available"),
			array("plc.uk","whois.nic.uk","No match for"),
			array("odo.br","whois.nic.br","No match"),
			array("oop.br","whois.nic.br","No match"),
			array("or.jp","whois.nic.ad.jp","No match"),
			array("org","whois.pir.org","NOT FOUND"),
			array("org.au","whois.aunic.net","No Data Found"),
			array("org.br","whois.nic.br","No match"),
			array("org.cn","whois.cnnic.net.cn","No entries found"),
			array("org.hk","whois.hknic.net.hk","No Match for"),
			array("org.lu","whois.dns.lu","No entries found"),
			array("org.ru","whois.ripn.ru","No entries found"),
			array("org.tw","whois.twnic.net","NO MATCH TIP"),
			array("org.uk","whois.nic.uk","No match for"),
			array("pl","nazgul.nask.waw.pl","does not exists"),
			array("plc.uk","whois.nic.uk","No match for"),
			array("pp.ru","whois.ripn.ru","No entries found"),
			array("ppg.br","whois.nic.br","No match"),
			array("pro.br","whois.nic.br","No match"),
			array("psi.br","whois.nic.br","No match"),
			array("psc.br","whois.nic.br","No match"),
			array("pt","whois.ripe.net","No entries found"),
			array("qh.cn","whois.cnnic.net.cn","No entries found"),
			array("qsl.br","whois.nic.br","No match"),
			array("rec.br","whois.nic.br","No match"),
			array("ro","whois.rotld.ro","No entries found"),
			array("ru","whois.ripn.ru","No entries found"),
			array("sc.cn","whois.cnnic.net.cn","No entries found"),
			array("sd.cn","whois.cnnic.net.cn","No entries found"),
			array("se","whois.nic-se.se","No data found"),
			array("sg","whois.nic.net.sg","NO entry found"),
			array("sh","whois.nic.sh","No match for"),
			array("sh.cn","whois.cnnic.net.cn","No entries found"),
			array("si","whois.arnes.si","No entries found"),
			array("sk","whois.ripe.net","no entries found"),
			array("slg.br","whois.nic.br","No match"),
			array("sm","whois.ripe.net","no entries found"),
			array("sn.cn","whois.cnnic.net.cn","No entries found"),
			array("srv.br","whois.nic.br","No match"),
			array("st","whois.nic.st","No entries found"),
			array("sx.cn","whois.cnnic.net.cn","No entries found"),
			array("tc","whois.adamsnames.tc","is not registered"),
			array("th","whois.nic.uk","No entries found"),
			array("tj.cn","whois.cnnic.net.cn","No entries found"),
			array("tld.uk","whois.nic.uk","No match for"),
			array("tmp.br","whois.nic.br","No match"),
			array("to","whois.tonic.to","No match"),
			array("tr","whois.ripe.net","Not found in database"),
			array("trd.br","whois.nic.br","No match"),
			array("tur.br","whois.nic.br","No match"),
			array("tv","whois.tv","MAXCHARS:75"),
			array("tv.br","whois.nic.br","No match"),
			array("tw","whois.twnic.net","NO MATCH TIP"),
			array("tw.cn","whois.cnnic.net.cn","No entries found"),
			array("uk","whois.thnic.net","No match for"),
			array("us","whois.nic.us","Not found:"),
			array("va","whois.ripe.net","No entries found"),
			array("vet.br","whois.nic.br","No match"),
			array("vg","whois.adamsnames.tc","is not registered"),
			array("wattle.id.au","whois.aunic.net","No Data Found"),
			array("ws","whois.worldsite.ws","No match for"),
			array("xj.cn","whois.cnnic.net.cn","No entries found"),
			array("xz.cn","whois.cnnic.net.cn","No entries found"),
			array("yn.cn","whois.cnnic.net.cn","No entries found"),
			array("zlg.br","whois.nic.br","No match"),
			array("zj.cn","whois.cnnic.net.cn","No entries found"),
			array("fo","whois.ripe.net","no entries found")
        );
		$whocnt = count( $servers );
        for ($x=0; $x<$whocnt; $x++){
			$artld = $servers[$x][0];
			$tldlen = intval(0 - strlen($artld));
			if (substr($domain, $tldlen) == $artld) {
				$out[0] = $servers[$x][1];
				$out[1] = $servers[$x][2];
				return $out;
			}
        }
        return $out;
	}
	
	function lookup(){
		$dom = $this->domain;
		$whoinf = $this->get_whois_info( $dom );
		$lusrv = $whoinf[0];
		$notfndtxt = $whoinf[1];
		
		if (!$lusrv) return "";
		
		$fp = fsockopen($lusrv,43);
		fputs($fp, "$dom\r\n");
		$string="";
		while(!feof($fp)){
			$string.= fgets($fp,128);
		}
		fclose($fp);
		
		$reg = "/Whois Server: (.*?)\n/i";
		preg_match_all($reg, $string, $matches);
		$secondtry = $matches[1][0];
		
		if ($secondtry){
			$fp = fsockopen($secondtry,43);
			fputs($fp, "$dom\r\n");
			$string = "";
			
			while(!feof($fp)){
				$string.=fgets($fp,128);
			}
			fclose($fp);
		}
		
		if (stristr($string, $notfndtxt)) $data[0] = "1";
		$data[1] = $string;
		
		return $data;
	}

    function info() {
        if ($this->is_valid()) {
            $whois_server = $this->servers[$this->tldname][0];

            // If tldname have been found
            if ($whois_server != '') {
                // Getting whois information
                $fp = fsockopen($whois_server, 43);
                if (!$fp) {
                    return "Connection error!";
                }

                $dom = $this->domainname . '.' . $this->tldname;
                fputs($fp, "$dom\r\n");

                // Getting string
                $string = '';

                // Checking whois server for .com and .net
                if ($this->tldname == 'com' || $this->tldname == 'net') {
                    while (!feof($fp)) {
                        $line = trim(fgets($fp, 128));

                        $string .= $line;

                        $lineArr = split(":", $line);

                        if (strtolower($lineArr[0]) == 'whois server') {
                            $whois_server = trim($lineArr[1]);
                        }
                    }
                    // Getting whois information
                    $fp = fsockopen($whois_server, 43);
                    if (!$fp) {
                        return "Connection error!";
                    }


                    $dom = $this->domainname . '.' . $this->tldname;
                    fputs($fp, "$dom\r\n");

                    // Getting string
                    $string = '';

                    while (!feof($fp)) {
                        $string .= fgets($fp, 128);
                    }

                    // Checking for other tld's
                } else {
                    while (!feof($fp)) {
                        $string .= fgets($fp, 128);
                    }
                }
                fclose($fp);

                return htmlspecialchars($string);
            } else {
                return "No whois server for this tld in list!";
            }
        } else {
            return "Domainname isn't valid!";
        }
    }

    function html_info() {
        return nl2br($this->info());
    }

    function get_tld() {
        $domain = split("\.", $this->domain);
        if (count($domain) > 2) {
            for ($i = 1; $i < count($domain); $i++) {
                if ($i == 1) {
                    $this->tldname = $domain[$i];
                } else {
                    $this->tldname .= '.' . $domain[$i];
                }
            }
        } else {
            $this->tldname = $domain[1];
        }
    }

    function get_domain() {
        $domain = split("\.", $this->domain);
        $this->domainname = $domain[0];
    }

    function is_available() {
        $whois_string = $this->info();
        $not_found_string = '';
        if (isset($this->servers[$this->tldname][1])) {
           $not_found_string = $this->servers[$this->tldname][1];
        }

        $whois_string2 = @ereg_replace($this->domain, '', $whois_string);
        $whois_string = @preg_replace("/\s+/", ' ', $whois_string);

        $array = split(":", $not_found_string);
        if ($array[0] == "MAXCHARS") {
            if (strlen($whois_string2) <= $array[1]) {
                return true;
            } else {
                return false;
            }
        } else {
            if (preg_match("/" . $not_found_string . "/i", $whois_string)) {
                return true;
            } else {
                return false;
            }
        }
    }

    function is_valid() {
        if (
            isset($this->servers[$this->tldname][0]) 
            && strlen($this->servers[$this->tldname][0]) > 6
        ) {
            $tmp_domain = strtolower($this->domainname);
            if (
                ereg("^[a-z0-9\-]{3,}$", $tmp_domain) 
                && !ereg("^-|-$", $tmp_domain) && !preg_match("/--/", $tmp_domain)
            ) {
                return true;
            }
        }
        return false;
    }
}

?>