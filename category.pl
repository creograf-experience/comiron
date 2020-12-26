#!perl
	print "truncate category_parent;\n";
	print "truncate category;\n";
	
	my %was;

	open FILE, "category.txt";
	foreach(<FILE>){
		# $name_it,$name_ch,$name_en,
		my ($name_ru, $id, $category_id,$stuff) = split /\t/ ;
		print "INSERT INTO `comiron`.`category` (`id`,  `category_id`, `visible`, `ordr`, `thumbnail_url`, `ispopular`, `name_ru`) VALUES ($id,  NULL, '1', $id, NULL, '0', \"".$name_ru."\");\n" 
			unless($was{$id});
#		print "INSERT INTO `comiron`.`category` (`id`, `name_en`, `category_id`, `visible`, `ordr`, `thumbnail_url`, `ispopular`, `name_ch`, `name_ru`, `name_it`) VALUES ($id, \"".$name_en."\", NULL, '1', $id, NULL, '0', \"".$name_ch."\", \"".$name_ru."\", \"".$name_it."\");\n" 
#			unless($was{$id});
		print "insert into `comiron`.`category_parent` (`id`, `category_id`) values (".$id.", ".$category_id.");\n";

		$was{$id}=1;
	}
	close FILE;



