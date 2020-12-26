<?php 
// Мультиязычная транслитерация
class Translit {
    private $name;
    private $name;
    private $name;
    
    //TODO конструктор
    public function new($class,$name){
	    my $class = shift();
	    my $name  = shift();
	    my $table = Lingua::Translit::Tables::_get_table_reference($name);

    	$this->name   = $table['name'];
    	$this->desc  = $table['desc'];
    	$this->rules  = $table['rules'];

	    $this->reverse = ($table->['reverse'] =~ /^true$/i) ? 1 : 0;
	}

public function translit($text){
    my $utf8_flag_on = Encode::is_utf8($text);

    unless ($utf8_flag_on)
    {
        $text = decode("UTF-8", $text);
    }

    # Return if no input was given
    return unless $text;

    # Copy over the input string. It will be modified directly.
    my $tr_text = $text;

    foreach my $rule (@{$self->{rules}})
    {
        if (defined $rule->{context})
        {
            my $c = $rule->{context};

            # single context rules
            if (defined $c->{before}   && !defined $c->{after})
            {
                $tr_text =~ s/\Q$rule->{from}\E(?=$c->{before})/$rule->{to}/g;
            }
            elsif (defined $c->{after} && !defined $c->{before})
            {
                $tr_text =~ s/(?<=$c->{after})\Q$rule->{from}\E/$rule->{to}/g;
            }

            # double context rules: logical "inbetween"
            elsif (defined $c->{before} && defined $c->{after})
            {
            $tr_text =~
                s/
                (?<=$c->{after})\Q$rule->{from}\E(?=$c->{before})
                /$rule->{to}/gx;
            }

            else
            {
                croak("incomplete rule context");
            }
        }
        else
        {
            $tr_text =~ s/\Q$rule->{from}\E/$rule->{to}/g;
        }
    }

    unless ($utf8_flag_on)
    {
        return encode("UTF-8", $tr_text);
    }
    else
    {
        return $tr_text;
    }
}

function public translit_reverse
{
    my $self = shift();
    my $text = shift();

    my $utf8_flag_on = Encode::is_utf8($text);

    unless ($utf8_flag_on)
    {
        $text = decode("UTF-8", $text);
    }

    # Return if no input was given
    return unless $text;

    # Is this transliteration reversible?
    croak("$self->{name} cannot be reversed") unless $self->{reverse};

    # Copy over the input string. It will be modified directly.
    my $tr_text = $text;

    foreach my $rule (@{$self->{rules}})
    {
        if (defined $rule->{context})
        {
            my $c = $rule->{context};

            # single context rules
            if (defined $c->{before} && !defined $c->{after})
            {
                $tr_text =~ s/\Q$rule->{to}\E(?=$c->{before})/$rule->{from}/g;
            }
            elsif (defined $c->{after} && !defined $c->{before})
            {
                $tr_text =~ s/(?<=$c->{after})\Q$rule->{to}\E/$rule->{from}/g;
            }

            # double context rules: logical "inbetween"
            elsif (defined $c->{before} && defined $c->{after})
            {
                $tr_text =~
                    s/
                    (?<=$c->{after})\Q$rule->{to}\E(?=$c->{before})
                    /$rule->{from}/gx;
            }

            else
            {
                croak("incomplete rule context");
            }
        }
        else
        {
            $tr_text =~ s/\Q$rule->{to}\E/$rule->{from}/g;
        }
    }

    unless ($utf8_flag_on)
    {
        return encode("UTF-8", $tr_text);
    }
    else
    {
        return $tr_text;
    }
}


=head2 can_reverse()

Returns true (1), iff reverse transliteration is possible.
False (0) otherwise.

=cut

sub can_reverse
{
    return $_[0]->{reverse};
}


=head2 name()

Returns the name of the chosen transliteration table, e.g. "ISO 9".

=cut

sub name
{
    return $_[0]->{name};
}


=head2 desc()

Returns a description for the transliteration,
e.g. "ISO 9:1995, Cyrillic to Latin".

=cut

sub desc
{
    return $_[0]->{desc};
}


=head1 SUPPORTED TRANSLITERATIONS

=over 4

=item Cyrillic

I<ALA-LC RUS>, not reversible, ALA-LC:1997, Cyrillic to Latin, Russian

I<ISO 9>, reversible, ISO 9:1995, Cyrillic to Latin

I<DIN 1460 RUS>, reversible, DIN 1460:1982, Cyrillic to Latin, Russian

I<DIN 1460 UKR>, reversible, DIN 1460:1982, Cyrillic to Latin, Ukrainian

I<DIN 1460 BUL>, reversible, DIN 1460:1982, Cyrillic to Latin, Bulgarian

I<Streamlined System BUL>, not reversible, The Streamlined System: 2006,
Cyrillic to Latin, Bulgarian

I<GOST 7.79 RUS>, reversible, GOST 7.79:2000 (table B), Cyrillic to Latin,
Russian

I<GOST 7.79 RUS OLD>, not reversible, GOST 7.79:2000 (table B), Cyrillic to
Latin with support for Old Russian (pre 1918), Russian

I<GOST 7.79 UKR>, reversible, GOST 7.79:2000 (table B), Cyrillic to Latin,
Ukrainian

=item Greek

I<ISO 843>, not reversible, ISO 843:1997, Greek to Latin

I<DIN 31634>, not reversible, DIN 31634:1982, Greek to Latin

I<Greeklish>, not reversible, Greeklish (Phonetic), Greek to Latin

=item Latin

I<Common CES>, not reversible, Czech without diacritics

I<Common DEU>, not reversible, German without umlauts

I<Common POL>, not reversible, Unaccented Polish

I<Common RON>, not reversible, Romanian without diacritics as commonly used

I<Common SLK>, not reversible, Slovak without diacritics

I<Common SLV>, not reversible, Slovenian without diacritics

=item Mongolian

I<Common Classical MON>, reversible, Classical Mongolian to Latin

=back

=head1 ADDING NEW TRANSLITERATIONS

In case you want to add your own transliteration tables to
L<Lingua::Translit>, have a look at the developer manual included in the
distribution.
An online version is available at
L<http://www.lingua-systems.com/downloads/Lingua-Translit/>.

A template of a transliteration table is provided as well
(F<xml/template.xml>) so you can easily start developing.


=head1 RESTRICTIONS

L<Lingua::Translit> is suited to handle B<Unicode> and utilizes comparisons
and regular expressions that rely on B<code points>.
Therefore, any input is supposed to be B<character oriented>
(C<use utf8;>, ...) instead of byte oriented.

However, if your data is byte oriented, be sure to pass it
B<UTF-8 encoded> to translit() and/or translit_reverse() - it will be
converted internally.

=head1 BUGS

None known.

Please report bugs to perl@lingua-systems.com.

=head1 SEE ALSO

L<Lingua::Translit::Tables>, L<Encode>, L<perlunicode>

L<translit(1)>

L<http://www.lingua-systems.com/transliteration/Lingua-Translit-Perl-module/>

L<http://www.lingua-systems.com/transliteration/Lingua-Translit-Perl-module/online-transliteration.html>
provides an online frontend for L<Lingua::Translit>.

=head1 CREDITS

Thanks to Dr. Daniel Eiwen, Romanisches Seminar, Universitaet Koeln for his
help on Romanian transliteration.

Thanks to Bayanzul Lodoysamba <baynaa@users.sourceforge.net> for contributing
the "Common Classical Mongolian" transliteration table.

Thanks to Dmitry Smal and Rusar Publishing for contributing the "ALA-LC RUS"
transliteration table.

=head1 AUTHORS

Alex Linke <alinke@lingua-systems.com>

Rona Linke <rlinke@lingua-systems.com>

=head1 LICENSE AND COPYRIGHT

Copyright (C) 2007-2008 Alex Linke and Rona Linke

Copyright (C) 2009-2011 Lingua-Systems Software GmbH

This module is free software. It may be used, redistributed
and/or modified under the terms of either the GPL v2 or the
Artistic license.

=cut


1;


# vim: sts=4 sw=4 ai et

$tables = array(
  "common_slk" => {
    "desc" => "Slovak without diacritics",
    "name" => "Common SLK",
    "id" => "common_slk",
    "rules" => [
      {
        "to" => "A",
        "from" => "\x{c1}"
      },
      {
        "to" => "a",
        "from" => "\x{e1}"
      },
      {
        "to" => "A",
        "from" => "\x{c4}"
      },
      {
        "to" => "a",
        "from" => "\x{e4}"
      },
      {
        "to" => "C",
        "from" => "\x{10c}"
      },
      {
        "to" => "c",
        "from" => "\x{10d}"
      },
      {
        "to" => "D",
        "from" => "\x{10e}"
      },
      {
        "to" => "d",
        "from" => "\x{10f}"
      },
      {
        "to" => "d",
        "from" => "d\x{30c}"
      },
      {
        "to" => "E",
        "from" => "\x{c9}"
      },
      {
        "to" => "e",
        "from" => "\x{e9}"
      },
      {
        "to" => "I",
        "from" => "\x{cd}"
      },
      {
        "to" => "i",
        "from" => "\x{ed}"
      },
      {
        "to" => "L",
        "from" => "\x{139}"
      },
      {
        "to" => "l",
        "from" => "\x{13a}"
      },
      {
        "to" => "L",
        "from" => "\x{13d}"
      },
      {
        "to" => "l",
        "from" => "\x{13e}"
      },
      {
        "to" => "L",
        "from" => "L\x{30c}"
      },
      {
        "to" => "l",
        "from" => "l\x{30c}"
      },
      {
        "to" => "N",
        "from" => "\x{147}"
      },
      {
        "to" => "n",
        "from" => "\x{148}"
      },
      {
        "to" => "O",
        "from" => "\x{d3}"
      },
      {
        "to" => "o",
        "from" => "\x{f3}"
      },
      {
        "to" => "R",
        "from" => "\x{154}"
      },
      {
        "to" => "r",
        "from" => "\x{155}"
      },
      {
        "to" => "S",
        "from" => "\x{160}"
      },
      {
        "to" => "s",
        "from" => "\x{161}"
      },
      {
        "to" => "T",
        "from" => "\x{164}"
      },
      {
        "to" => "t",
        "from" => "\x{165}"
      },
      {
        "to" => "t",
        "from" => "t\x{30c}"
      },
      {
        "to" => "U",
        "from" => "\x{da}"
      },
      {
        "to" => "u",
        "from" => "\x{fa}"
      },
      {
        "to" => "Y",
        "from" => "\x{dd}"
      },
      {
        "to" => "y",
        "from" => "\x{fd}"
      },
      {
        "to" => "Z",
        "from" => "\x{17d}"
      },
      {
        "to" => "z",
        "from" => "\x{17e}"
      },
      {
        "to" => "O",
        "from" => "\x{d4}"
      },
      {
        "to" => "o",
        "from" => "\x{f4}"
      },
      {
        "to" => "DZ",
        "from" => "\x{1f1}"
      },
      {
        "to" => "Dz",
        "from" => "\x{1f2}"
      },
      {
        "to" => "dz",
        "from" => "\x{1f3}"
      },
      {
        "to" => "DZ",
        "from" => "\x{1c4}"
      },
      {
        "to" => "Dz",
        "from" => "\x{1c5}"
      },
      {
        "to" => "dz",
        "from" => "\x{1c6}"
      }
    ],
    "reverse" => "false"
  },
  "common_ron" => {
    "desc" => "Romanian without diacritics",
    "name" => "Common RON",
    "id" => "common_ron",
    "rules" => [
      {
        "to" => "A",
        "from" => "\x{102}"
      },
      {
        "to" => "a",
        "from" => "\x{103}"
      },
      {
        "to" => "A",
        "from" => "\x{c2}"
      },
      {
        "to" => "a",
        "from" => "\x{e2}"
      },
      {
        "to" => "I",
        "from" => "\x{ce}"
      },
      {
        "to" => "i",
        "from" => "\x{ee}"
      },
      {
        "to" => "S",
        "from" => "\x{218}"
      },
      {
        "to" => "s",
        "from" => "\x{219}"
      },
      {
        "to" => "S",
        "from" => "\x{15e}"
      },
      {
        "to" => "s",
        "from" => "\x{15f}"
      },
      {
        "to" => "T",
        "from" => "\x{21a}"
      },
      {
        "to" => "t",
        "from" => "\x{21b}"
      },
      {
        "to" => "T",
        "from" => "\x{162}"
      },
      {
        "to" => "t",
        "from" => "\x{163}"
      }
    ],
    "reverse" => "false"
  },
  "common_pol" => {
    "desc" => "Unaccented Polish",
    "name" => "Common POL",
    "id" => "common_pol",
    "rules" => [
      {
        "to" => "A",
        "from" => "\x{104}"
      },
      {
        "to" => "a",
        "from" => "\x{105}"
      },
      {
        "to" => "C",
        "from" => "\x{106}"
      },
      {
        "to" => "c",
        "from" => "\x{107}"
      },
      {
        "to" => "E",
        "from" => "\x{118}"
      },
      {
        "to" => "e",
        "from" => "\x{119}"
      },
      {
        "to" => "L",
        "from" => "\x{141}"
      },
      {
        "to" => "l",
        "from" => "\x{142}"
      },
      {
        "to" => "N",
        "from" => "\x{143}"
      },
      {
        "to" => "n",
        "from" => "\x{144}"
      },
      {
        "to" => "O",
        "from" => "\x{d3}"
      },
      {
        "to" => "o",
        "from" => "\x{f3}"
      },
      {
        "to" => "S",
        "from" => "\x{15a}"
      },
      {
        "to" => "s",
        "from" => "\x{15b}"
      },
      {
        "to" => "Z",
        "from" => "\x{179}"
      },
      {
        "to" => "z",
        "from" => "\x{17a}"
      },
      {
        "to" => "Z",
        "from" => "\x{17b}"
      },
      {
        "to" => "z",
        "from" => "\x{17c}"
      }
    ],
    "reverse" => "false"
  },
  "streamlined_system_bul" => {
    "desc" => "The Streamlined System: 2006, Cyrillic to Latin, Bulgarian",
    "name" => "Streamlined System BUL",
    "id" => "streamlined_system_bul",
    "rules" => [
      {
        "to" => "SHT",
        "from" => "\x{429}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Sht",
        "from" => "\x{429}"
      },
      {
        "to" => "sht",
        "from" => "\x{449}"
      },
      {
        "to" => "ZH",
        "from" => "\x{416}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Zh",
        "from" => "\x{416}"
      },
      {
        "to" => "zh",
        "from" => "\x{436}"
      },
      {
        "to" => "TS",
        "from" => "\x{426}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ts",
        "from" => "\x{426}"
      },
      {
        "to" => "ts",
        "from" => "\x{446}"
      },
      {
        "to" => "CH",
        "from" => "\x{427}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ch",
        "from" => "\x{427}"
      },
      {
        "to" => "ch",
        "from" => "\x{447}"
      },
      {
        "to" => "SH",
        "from" => "\x{428}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Sh",
        "from" => "\x{428}"
      },
      {
        "to" => "sh",
        "from" => "\x{448}"
      },
      {
        "to" => "YU",
        "from" => "\x{42e}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Yu",
        "from" => "\x{42e}"
      },
      {
        "to" => "yu",
        "from" => "\x{44e}"
      },
      {
        "to" => "YA",
        "from" => "\x{42f}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ya",
        "from" => "\x{42f}"
      },
      {
        "to" => "ya",
        "from" => "\x{44f}"
      },
      {
        "to" => "A",
        "from" => "\x{410}"
      },
      {
        "to" => "a",
        "from" => "\x{430}"
      },
      {
        "to" => "B",
        "from" => "\x{411}"
      },
      {
        "to" => "b",
        "from" => "\x{431}"
      },
      {
        "to" => "V",
        "from" => "\x{412}"
      },
      {
        "to" => "v",
        "from" => "\x{432}"
      },
      {
        "to" => "G",
        "from" => "\x{413}"
      },
      {
        "to" => "g",
        "from" => "\x{433}"
      },
      {
        "to" => "D",
        "from" => "\x{414}"
      },
      {
        "to" => "d",
        "from" => "\x{434}"
      },
      {
        "to" => "E",
        "from" => "\x{415}"
      },
      {
        "to" => "e",
        "from" => "\x{435}"
      },
      {
        "to" => "Z",
        "from" => "\x{417}"
      },
      {
        "to" => "z",
        "from" => "\x{437}"
      },
      {
        "to" => "I",
        "from" => "\x{418}"
      },
      {
        "to" => "i",
        "from" => "\x{438}"
      },
      {
        "to" => "Y",
        "from" => "\x{419}"
      },
      {
        "to" => "y",
        "from" => "\x{439}"
      },
      {
        "to" => "K",
        "from" => "\x{41a}"
      },
      {
        "to" => "k",
        "from" => "\x{43a}"
      },
      {
        "to" => "L",
        "from" => "\x{41b}"
      },
      {
        "to" => "l",
        "from" => "\x{43b}"
      },
      {
        "to" => "M",
        "from" => "\x{41c}"
      },
      {
        "to" => "m",
        "from" => "\x{43c}"
      },
      {
        "to" => "N",
        "from" => "\x{41d}"
      },
      {
        "to" => "n",
        "from" => "\x{43d}"
      },
      {
        "to" => "O",
        "from" => "\x{41e}"
      },
      {
        "to" => "o",
        "from" => "\x{43e}"
      },
      {
        "to" => "P",
        "from" => "\x{41f}"
      },
      {
        "to" => "p",
        "from" => "\x{43f}"
      },
      {
        "to" => "R",
        "from" => "\x{420}"
      },
      {
        "to" => "r",
        "from" => "\x{440}"
      },
      {
        "to" => "S",
        "from" => "\x{421}"
      },
      {
        "to" => "s",
        "from" => "\x{441}"
      },
      {
        "to" => "T",
        "from" => "\x{422}"
      },
      {
        "to" => "t",
        "from" => "\x{442}"
      },
      {
        "to" => "U",
        "from" => "\x{423}"
      },
      {
        "to" => "u",
        "from" => "\x{443}"
      },
      {
        "to" => "F",
        "from" => "\x{424}"
      },
      {
        "to" => "f",
        "from" => "\x{444}"
      },
      {
        "to" => "H",
        "from" => "\x{425}"
      },
      {
        "to" => "h",
        "from" => "\x{445}"
      },
      {
        "to" => "A",
        "from" => "\x{42a}"
      },
      {
        "to" => "a",
        "from" => "\x{44a}"
      },
      {
        "to" => "Y",
        "from" => "\x{42c}"
      },
      {
        "to" => "y",
        "from" => "\x{44c}"
      }
    ],
    "reverse" => "false"
  },
  "gost_7.79_rus_old" => {
    "desc" => "GOST 7.79:2000, Cyrillic to Latin with support for Old Russian (pre 1918), Russian",
    "name" => "GOST 7.79 RUS OLD",
    "id" => "gost_7.79_rus_old",
    "rules" => [
      {
        "to" => "i'",
        "from" => "\x{456}",
        "context" => {
          "before" => "[^\x{430}\x{435}\x{451}\x{438}\x{43e}\x{443}\x{44b}\x{44d}\x{44e}\x{44f}\x{44d}\x{451}\x{463}\x{475}\x{456}]"
        }
      },
      {
        "to" => "I'",
        "from" => "\x{406}",
        "context" => {
          "before" => "[^\x{410}\x{415}\x{401}\x{418}\x{41e}\x{423}\x{42b}\x{42d}\x{42e}\x{42f}\x{401}\x{42d}\x{462}\x{474}\x{406}]"
        }
      },
      {
        "to" => "i",
        "from" => "\x{456}"
      },
      {
        "to" => "I",
        "from" => "\x{406}"
      },
      {
        "to" => "c",
        "from" => "\x{446}",
        "context" => {
          "before" => "[iejy\x{438}\x{435}\x{439}\x{44b}\x{44e}\x{44f}]"
        }
      },
      {
        "to" => "C",
        "from" => "\x{426}",
        "context" => {
          "before" => "[IEJY\x{418}\x{415}\x{419}\x{42b}\x{42e}\x{42f}]"
        }
      },
      {
        "to" => "cz",
        "from" => "\x{446}"
      },
      {
        "to" => "CZ",
        "from" => "\x{426}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Cz",
        "from" => "\x{426}"
      },
      {
        "to" => "a",
        "from" => "\x{430}"
      },
      {
        "to" => "A",
        "from" => "\x{410}"
      },
      {
        "to" => "b",
        "from" => "\x{431}"
      },
      {
        "to" => "B",
        "from" => "\x{411}"
      },
      {
        "to" => "v",
        "from" => "\x{432}"
      },
      {
        "to" => "V",
        "from" => "\x{412}"
      },
      {
        "to" => "g",
        "from" => "\x{433}"
      },
      {
        "to" => "G",
        "from" => "\x{413}"
      },
      {
        "to" => "d",
        "from" => "\x{434}"
      },
      {
        "to" => "D",
        "from" => "\x{414}"
      },
      {
        "to" => "e",
        "from" => "\x{435}"
      },
      {
        "to" => "E",
        "from" => "\x{415}"
      },
      {
        "to" => "yo",
        "from" => "\x{451}"
      },
      {
        "to" => "YO",
        "from" => "\x{401}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Yo",
        "from" => "\x{401}"
      },
      {
        "to" => "zh",
        "from" => "\x{436}"
      },
      {
        "to" => "ZH",
        "from" => "\x{416}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Zh",
        "from" => "\x{416}"
      },
      {
        "to" => "z",
        "from" => "\x{437}"
      },
      {
        "to" => "Z",
        "from" => "\x{417}"
      },
      {
        "to" => "i",
        "from" => "\x{438}"
      },
      {
        "to" => "I",
        "from" => "\x{418}"
      },
      {
        "to" => "j",
        "from" => "\x{439}"
      },
      {
        "to" => "J",
        "from" => "\x{419}"
      },
      {
        "to" => "k",
        "from" => "\x{43a}"
      },
      {
        "to" => "K",
        "from" => "\x{41a}"
      },
      {
        "to" => "l",
        "from" => "\x{43b}"
      },
      {
        "to" => "L",
        "from" => "\x{41b}"
      },
      {
        "to" => "m",
        "from" => "\x{43c}"
      },
      {
        "to" => "M",
        "from" => "\x{41c}"
      },
      {
        "to" => "n",
        "from" => "\x{43d}"
      },
      {
        "to" => "N",
        "from" => "\x{41d}"
      },
      {
        "to" => "o",
        "from" => "\x{43e}"
      },
      {
        "to" => "O",
        "from" => "\x{41e}"
      },
      {
        "to" => "p",
        "from" => "\x{43f}"
      },
      {
        "to" => "P",
        "from" => "\x{41f}"
      },
      {
        "to" => "r",
        "from" => "\x{440}"
      },
      {
        "to" => "R",
        "from" => "\x{420}"
      },
      {
        "to" => "s",
        "from" => "\x{441}"
      },
      {
        "to" => "S",
        "from" => "\x{421}"
      },
      {
        "to" => "t",
        "from" => "\x{442}"
      },
      {
        "to" => "T",
        "from" => "\x{422}"
      },
      {
        "to" => "u",
        "from" => "\x{443}"
      },
      {
        "to" => "U",
        "from" => "\x{423}"
      },
      {
        "to" => "f",
        "from" => "\x{444}"
      },
      {
        "to" => "F",
        "from" => "\x{424}"
      },
      {
        "to" => "x",
        "from" => "\x{445}"
      },
      {
        "to" => "X",
        "from" => "\x{425}"
      },
      {
        "to" => "ch",
        "from" => "\x{447}"
      },
      {
        "to" => "CH",
        "from" => "\x{427}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ch",
        "from" => "\x{427}"
      },
      {
        "to" => "sh",
        "from" => "\x{448}"
      },
      {
        "to" => "SH",
        "from" => "\x{428}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Sh",
        "from" => "\x{428}"
      },
      {
        "to" => "shh",
        "from" => "\x{449}"
      },
      {
        "to" => "SHH",
        "from" => "\x{429}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Shh",
        "from" => "\x{429}"
      },
      {
        "to" => "``",
        "from" => "\x{44a}"
      },
      {
        "to" => "``",
        "from" => "\x{42a}"
      },
      {
        "to" => "y'",
        "from" => "\x{44b}"
      },
      {
        "to" => "Y'",
        "from" => "\x{42b}"
      },
      {
        "to" => "`",
        "from" => "\x{42c}"
      },
      {
        "to" => "`",
        "from" => "\x{44c}"
      },
      {
        "to" => "e`",
        "from" => "\x{44d}"
      },
      {
        "to" => "E`",
        "from" => "\x{42d}"
      },
      {
        "to" => "yu",
        "from" => "\x{44e}"
      },
      {
        "to" => "YU",
        "from" => "\x{42e}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Yu",
        "from" => "\x{42e}"
      },
      {
        "to" => "ya",
        "from" => "\x{44f}"
      },
      {
        "to" => "YA",
        "from" => "\x{42f}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ya",
        "from" => "\x{42f}"
      },
      {
        "to" => "ye",
        "from" => "\x{463}"
      },
      {
        "to" => "YE",
        "from" => "\x{462}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ye",
        "from" => "\x{462}"
      },
      {
        "to" => "fh",
        "from" => "\x{473}"
      },
      {
        "to" => "FH",
        "from" => "\x{472}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Fh",
        "from" => "\x{472}"
      },
      {
        "to" => "yh",
        "from" => "\x{475}"
      },
      {
        "to" => "YH",
        "from" => "\x{474}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Yh",
        "from" => "\x{474}"
      },
      {
        "to" => "#",
        "from" => "\x{2116}"
      }
    ],
    "reverse" => "false"
  },
  "din_1460_rus" => {
    "desc" => "DIN 1460:1982, Cyrillic to Latin, Russian",
    "name" => "DIN 1460 RUS",
    "id" => "din_1460_rus",
    "rules" => [
      {
        "to" => "ch",
        "from" => "\x{445}"
      },
      {
        "to" => "CH",
        "from" => "\x{425}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ch",
        "from" => "\x{425}"
      },
      {
        "to" => "\x{161}\x{10d}",
        "from" => "\x{449}"
      },
      {
        "to" => "\x{160}\x{10c}",
        "from" => "\x{429}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "\x{160}\x{10d}",
        "from" => "\x{429}"
      },
      {
        "to" => "\"",
        "from" => "\x{42a}",
        "context" => {
          "after" => "\\p{IsUpper}",
          "before" => "([^\\p{IsWord}]|\$)"
        }
      },
      {
        "to" => "\"",
        "from" => "\x{44a}",
        "context" => {
          "after" => "\\p{IsWord}",
          "before" => "([^\\p{IsWord}]|\$)"
        }
      },
      {
        "to" => "\"",
        "from" => "\x{44a}",
        "context" => {
          "after" => "\\p{IsWord}",
          "before" => "\\p{IsWord}"
        }
      },
      {
        "to" => "\"",
        "from" => "\x{42a}",
        "context" => {
          "after" => "\\p{IsWord}",
          "before" => "\\p{IsWord}"
        }
      },
      {
        "to" => "ju",
        "from" => "\x{44e}"
      },
      {
        "to" => "JU",
        "from" => "\x{42e}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ju",
        "from" => "\x{42e}"
      },
      {
        "to" => "ja",
        "from" => "\x{44f}"
      },
      {
        "to" => "JA",
        "from" => "\x{42f}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ja",
        "from" => "\x{42f}"
      },
      {
        "to" => "J-",
        "from" => "\x{419}",
        "context" => {
          "before" => "[auAU\x{430}\x{443}\x{410}\x{423}]"
        }
      },
      {
        "to" => "j-",
        "from" => "\x{439}",
        "context" => {
          "before" => "[au\x{430}\x{443}]"
        }
      },
      {
        "to" => "\x{160}-",
        "from" => "\x{428}",
        "context" => {
          "before" => "[\x{10c}\x{10d}\x{427}\x{447}]"
        }
      },
      {
        "to" => "\x{161}-",
        "from" => "\x{448}",
        "context" => {
          "before" => "[\x{10d}\x{447}]"
        }
      },
      {
        "to" => "a",
        "from" => "\x{430}"
      },
      {
        "to" => "A",
        "from" => "\x{410}"
      },
      {
        "to" => "b",
        "from" => "\x{431}"
      },
      {
        "to" => "B",
        "from" => "\x{411}"
      },
      {
        "to" => "v",
        "from" => "\x{432}"
      },
      {
        "to" => "V",
        "from" => "\x{412}"
      },
      {
        "to" => "g",
        "from" => "\x{433}"
      },
      {
        "to" => "G",
        "from" => "\x{413}"
      },
      {
        "to" => "d",
        "from" => "\x{434}"
      },
      {
        "to" => "D",
        "from" => "\x{414}"
      },
      {
        "to" => "e",
        "from" => "\x{435}"
      },
      {
        "to" => "E",
        "from" => "\x{415}"
      },
      {
        "to" => "\x{eb}",
        "from" => "\x{451}"
      },
      {
        "to" => "\x{cb}",
        "from" => "\x{401}"
      },
      {
        "to" => "\x{17e}",
        "from" => "\x{436}"
      },
      {
        "to" => "\x{17d}",
        "from" => "\x{416}"
      },
      {
        "to" => "z",
        "from" => "\x{437}"
      },
      {
        "to" => "Z",
        "from" => "\x{417}"
      },
      {
        "to" => "i",
        "from" => "\x{438}"
      },
      {
        "to" => "I",
        "from" => "\x{418}"
      },
      {
        "to" => "i",
        "from" => "\x{456}"
      },
      {
        "to" => "I",
        "from" => "\x{406}"
      },
      {
        "to" => "j",
        "from" => "\x{439}"
      },
      {
        "to" => "J",
        "from" => "\x{419}"
      },
      {
        "to" => "k",
        "from" => "\x{43a}"
      },
      {
        "to" => "K",
        "from" => "\x{41a}"
      },
      {
        "to" => "l",
        "from" => "\x{43b}"
      },
      {
        "to" => "L",
        "from" => "\x{41b}"
      },
      {
        "to" => "m",
        "from" => "\x{43c}"
      },
      {
        "to" => "M",
        "from" => "\x{41c}"
      },
      {
        "to" => "n",
        "from" => "\x{43d}"
      },
      {
        "to" => "N",
        "from" => "\x{41d}"
      },
      {
        "to" => "o",
        "from" => "\x{43e}"
      },
      {
        "to" => "O",
        "from" => "\x{41e}"
      },
      {
        "to" => "p",
        "from" => "\x{43f}"
      },
      {
        "to" => "P",
        "from" => "\x{41f}"
      },
      {
        "to" => "r",
        "from" => "\x{440}"
      },
      {
        "to" => "R",
        "from" => "\x{420}"
      },
      {
        "to" => "s",
        "from" => "\x{441}"
      },
      {
        "to" => "S",
        "from" => "\x{421}"
      },
      {
        "to" => "t",
        "from" => "\x{442}"
      },
      {
        "to" => "T",
        "from" => "\x{422}"
      },
      {
        "to" => "u",
        "from" => "\x{443}"
      },
      {
        "to" => "U",
        "from" => "\x{423}"
      },
      {
        "to" => "f",
        "from" => "\x{444}"
      },
      {
        "to" => "F",
        "from" => "\x{424}"
      },
      {
        "to" => "c",
        "from" => "\x{446}"
      },
      {
        "to" => "C",
        "from" => "\x{426}"
      },
      {
        "to" => "\x{10d}",
        "from" => "\x{447}"
      },
      {
        "to" => "\x{10c}",
        "from" => "\x{427}"
      },
      {
        "to" => "\x{161}",
        "from" => "\x{448}"
      },
      {
        "to" => "\x{160}",
        "from" => "\x{428}"
      },
      {
        "to" => "y",
        "from" => "\x{44b}"
      },
      {
        "to" => "Y",
        "from" => "\x{42b}"
      },
      {
        "to" => "'",
        "from" => "\x{42c}",
        "context" => {
          "after" => "\\p{IsUpper}"
        }
      },
      {
        "to" => "'",
        "from" => "\x{44c}"
      },
      {
        "to" => "\x{11b}",
        "from" => "\x{463}"
      },
      {
        "to" => "\x{11a}",
        "from" => "\x{462}"
      },
      {
        "to" => "\x{117}",
        "from" => "\x{44d}"
      },
      {
        "to" => "\x{116}",
        "from" => "\x{42d}"
      },
      {
        "to" => "\x{1e1f}",
        "from" => "\x{473}"
      },
      {
        "to" => "\x{1e1e}",
        "from" => "\x{472}"
      },
      {
        "to" => "\x{1e8f}",
        "from" => "\x{475}"
      },
      {
        "to" => "\x{1e8e}",
        "from" => "\x{474}"
      }
    ],
    "reverse" => "true"
  },
  "iso_9" => {
    "desc" => "ISO 9:1995, Cyrillic to Latin",
    "name" => "ISO 9",
    "id" => "iso_9",
    "rules" => [
      {
        "to" => "A",
        "from" => "\x{410}"
      },
      {
        "to" => "a",
        "from" => "\x{430}"
      },
      {
        "to" => "\x{102}",
        "from" => "\x{4d0}"
      },
      {
        "to" => "\x{103}",
        "from" => "\x{4d1}"
      },
      {
        "to" => "\x{c4}",
        "from" => "\x{4d2}"
      },
      {
        "to" => "\x{e4}",
        "from" => "\x{4d3}"
      },
      {
        "to" => "A\x{30b}",
        "from" => "\x{4d8}"
      },
      {
        "to" => "a\x{30b}",
        "from" => "\x{4d9}"
      },
      {
        "to" => "B",
        "from" => "\x{411}"
      },
      {
        "to" => "b",
        "from" => "\x{431}"
      },
      {
        "to" => "V",
        "from" => "\x{412}"
      },
      {
        "to" => "v",
        "from" => "\x{432}"
      },
      {
        "to" => "G",
        "from" => "\x{413}"
      },
      {
        "to" => "g",
        "from" => "\x{433}"
      },
      {
        "to" => "G\x{300}",
        "from" => "\x{490}"
      },
      {
        "to" => "g\x{300}",
        "from" => "\x{491}"
      },
      {
        "to" => "\x{11e}",
        "from" => "\x{494}"
      },
      {
        "to" => "\x{11f}",
        "from" => "\x{495}"
      },
      {
        "to" => "\x{120}",
        "from" => "\x{492}"
      },
      {
        "to" => "\x{121}",
        "from" => "\x{493}"
      },
      {
        "to" => "D",
        "from" => "\x{414}"
      },
      {
        "to" => "d",
        "from" => "\x{434}"
      },
      {
        "to" => "\x{110}",
        "from" => "\x{402}"
      },
      {
        "to" => "\x{111}",
        "from" => "\x{452}"
      },
      {
        "to" => "\x{1f4}",
        "from" => "\x{403}"
      },
      {
        "to" => "\x{1f5}",
        "from" => "\x{453}"
      },
      {
        "to" => "E",
        "from" => "\x{415}"
      },
      {
        "to" => "e",
        "from" => "\x{435}"
      },
      {
        "to" => "\x{cb}",
        "from" => "\x{401}"
      },
      {
        "to" => "\x{eb}",
        "from" => "\x{451}"
      },
      {
        "to" => "\x{114}",
        "from" => "\x{4d6}"
      },
      {
        "to" => "\x{115}",
        "from" => "\x{4d7}"
      },
      {
        "to" => "\x{ca}",
        "from" => "\x{404}"
      },
      {
        "to" => "\x{ea}",
        "from" => "\x{454}"
      },
      {
        "to" => "C\x{306}",
        "from" => "\x{4bc}"
      },
      {
        "to" => "c\x{306}",
        "from" => "\x{4bd}"
      },
      {
        "to" => "\x{c7}\x{306}",
        "from" => "\x{4be}"
      },
      {
        "to" => "\x{e7}\x{306}",
        "from" => "\x{4bf}"
      },
      {
        "to" => "\x{17d}",
        "from" => "\x{416}"
      },
      {
        "to" => "\x{17e}",
        "from" => "\x{436}"
      },
      {
        "to" => "Z\x{306}",
        "from" => "\x{4c1}"
      },
      {
        "to" => "z\x{306}",
        "from" => "\x{4c2}"
      },
      {
        "to" => "Z\x{304}",
        "from" => "\x{4dc}"
      },
      {
        "to" => "z\x{304}",
        "from" => "\x{4dd}"
      },
      {
        "to" => "\x{17d}\x{326}",
        "from" => "\x{496}"
      },
      {
        "to" => "\x{17e}\x{327}",
        "from" => "\x{497}"
      },
      {
        "to" => "Z",
        "from" => "\x{417}"
      },
      {
        "to" => "z",
        "from" => "\x{437}"
      },
      {
        "to" => "Z\x{308}",
        "from" => "\x{4de}"
      },
      {
        "to" => "z\x{308}",
        "from" => "\x{4df}"
      },
      {
        "to" => "\x{1e90}",
        "from" => "\x{405}"
      },
      {
        "to" => "\x{1e91}",
        "from" => "\x{455}"
      },
      {
        "to" => "\x{179}",
        "from" => "\x{4e0}"
      },
      {
        "to" => "\x{17a}",
        "from" => "\x{4e1}"
      },
      {
        "to" => "I",
        "from" => "\x{418}"
      },
      {
        "to" => "i",
        "from" => "\x{438}"
      },
      {
        "to" => "\x{ce}",
        "from" => "\x{4e4}"
      },
      {
        "to" => "\x{ee}",
        "from" => "\x{4e5}"
      },
      {
        "to" => "\x{cc}",
        "from" => "\x{406}"
      },
      {
        "to" => "\x{ec}",
        "from" => "\x{456}"
      },
      {
        "to" => "\x{cf}",
        "from" => "\x{407}"
      },
      {
        "to" => "\x{ef}",
        "from" => "\x{457}"
      },
      {
        "to" => "J",
        "from" => "\x{419}"
      },
      {
        "to" => "j",
        "from" => "\x{439}"
      },
      {
        "to" => "J\x{30c}",
        "from" => "\x{408}"
      },
      {
        "to" => "\x{1f0}",
        "from" => "\x{458}"
      },
      {
        "to" => "K",
        "from" => "\x{41a}"
      },
      {
        "to" => "k",
        "from" => "\x{43a}"
      },
      {
        "to" => "\x{136}",
        "from" => "\x{49a}"
      },
      {
        "to" => "\x{137}",
        "from" => "\x{49b}"
      },
      {
        "to" => "K\x{304}",
        "from" => "\x{49e}"
      },
      {
        "to" => "k\x{304}",
        "from" => "\x{49f}"
      },
      {
        "to" => "L",
        "from" => "\x{41b}"
      },
      {
        "to" => "l",
        "from" => "\x{43b}"
      },
      {
        "to" => "L\x{302}",
        "from" => "\x{409}"
      },
      {
        "to" => "l\x{302}",
        "from" => "\x{459}"
      },
      {
        "to" => "M",
        "from" => "\x{41c}"
      },
      {
        "to" => "m",
        "from" => "\x{43c}"
      },
      {
        "to" => "N",
        "from" => "\x{41d}"
      },
      {
        "to" => "n",
        "from" => "\x{43d}"
      },
      {
        "to" => "N\x{302}",
        "from" => "\x{40a}"
      },
      {
        "to" => "n\x{302}",
        "from" => "\x{45a}"
      },
      {
        "to" => "\x{1e44}",
        "from" => "\x{4a4}"
      },
      {
        "to" => "\x{1e45}",
        "from" => "\x{4a5}"
      },
      {
        "to" => "\x{1e46}",
        "from" => "\x{4a2}"
      },
      {
        "to" => "\x{1e47}",
        "from" => "\x{4a3}"
      },
      {
        "to" => "O",
        "from" => "\x{41e}"
      },
      {
        "to" => "o",
        "from" => "\x{43e}"
      },
      {
        "to" => "\x{d6}",
        "from" => "\x{4e6}"
      },
      {
        "to" => "\x{f6}",
        "from" => "\x{4e7}"
      },
      {
        "to" => "\x{d4}",
        "from" => "\x{4e8}"
      },
      {
        "to" => "\x{f4}",
        "from" => "\x{4e9}"
      },
      {
        "to" => "P",
        "from" => "\x{41f}"
      },
      {
        "to" => "p",
        "from" => "\x{43f}"
      },
      {
        "to" => "\x{1e54}",
        "from" => "\x{4a6}"
      },
      {
        "to" => "\x{1e55}",
        "from" => "\x{4a7}"
      },
      {
        "to" => "R",
        "from" => "\x{420}"
      },
      {
        "to" => "r",
        "from" => "\x{440}"
      },
      {
        "to" => "S",
        "from" => "\x{421}"
      },
      {
        "to" => "s",
        "from" => "\x{441}"
      },
      {
        "to" => "\x{c7}",
        "from" => "\x{4aa}"
      },
      {
        "to" => "\x{e7}",
        "from" => "\x{4ab}"
      },
      {
        "to" => "T",
        "from" => "\x{422}"
      },
      {
        "to" => "t",
        "from" => "\x{442}"
      },
      {
        "to" => "\x{162}",
        "from" => "\x{4ac}"
      },
      {
        "to" => "\x{163}",
        "from" => "\x{4ad}"
      },
      {
        "to" => "\x{106}",
        "from" => "\x{40b}"
      },
      {
        "to" => "\x{170}",
        "from" => "\x{45b}"
      },
      {
        "to" => "\x{1e30}",
        "from" => "\x{40c}"
      },
      {
        "to" => "\x{1e31}",
        "from" => "\x{45c}"
      },
      {
        "to" => "U",
        "from" => "\x{423}"
      },
      {
        "to" => "u",
        "from" => "\x{443}"
      },
      {
        "to" => "\x{da}",
        "from" => "\x{423}\x{301}"
      },
      {
        "to" => "\x{fa}",
        "from" => "\x{443}\x{301}"
      },
      {
        "to" => "\x{16c}",
        "from" => "\x{40e}"
      },
      {
        "to" => "\x{16d}",
        "from" => "\x{45e}"
      },
      {
        "to" => "\x{dc}",
        "from" => "\x{4f0}"
      },
      {
        "to" => "\x{fc}",
        "from" => "\x{4f1}"
      },
      {
        "to" => "\x{170}",
        "from" => "\x{4f2}"
      },
      {
        "to" => "\x{171}",
        "from" => "\x{4f3}"
      },
      {
        "to" => "\x{d9}",
        "from" => "\x{4ae}"
      },
      {
        "to" => "\x{f9}",
        "from" => "\x{4af}"
      },
      {
        "to" => "F",
        "from" => "\x{424}"
      },
      {
        "to" => "f",
        "from" => "\x{444}"
      },
      {
        "to" => "H",
        "from" => "\x{425}"
      },
      {
        "to" => "h",
        "from" => "\x{445}"
      },
      {
        "to" => "\x{1e28}",
        "from" => "\x{4b2}"
      },
      {
        "to" => "\x{1e29}",
        "from" => "\x{4b3}"
      },
      {
        "to" => "\x{1e24}",
        "from" => "\x{4ba}"
      },
      {
        "to" => "\x{1e25}",
        "from" => "\x{4bb}"
      },
      {
        "to" => "C",
        "from" => "\x{426}"
      },
      {
        "to" => "c",
        "from" => "\x{446}"
      },
      {
        "to" => "C\x{304}",
        "from" => "\x{4b4}"
      },
      {
        "to" => "c\x{304}",
        "from" => "\x{4b5}"
      },
      {
        "to" => "\x{10c}",
        "from" => "\x{427}"
      },
      {
        "to" => "\x{10d}",
        "from" => "\x{447}"
      },
      {
        "to" => "C\x{308}",
        "from" => "\x{4f4}"
      },
      {
        "to" => "c\x{308}",
        "from" => "\x{4f5}"
      },
      {
        "to" => "\x{c7}",
        "from" => "\x{4cb}"
      },
      {
        "to" => "\x{e7}",
        "from" => "\x{4cc}"
      },
      {
        "to" => "D\x{302}",
        "from" => "\x{40f}"
      },
      {
        "to" => "d\x{302}",
        "from" => "\x{45f}"
      },
      {
        "to" => "\x{160}",
        "from" => "\x{428}"
      },
      {
        "to" => "\x{161}",
        "from" => "\x{448}"
      },
      {
        "to" => "\x{15c}",
        "from" => "\x{429}"
      },
      {
        "to" => "\x{15d}",
        "from" => "\x{449}"
      },
      {
        "to" => "\x{2ba}",
        "from" => "\x{42a}",
        "context" => {
          "after" => "\\p{IsUpper}"
        }
      },
      {
        "to" => "\x{2ba}",
        "from" => "\x{44a}"
      },
      {
        "to" => "\x{2019}",
        "from" => "\x{2bc}"
      },
      {
        "to" => "Y",
        "from" => "\x{42b}"
      },
      {
        "to" => "y",
        "from" => "\x{44b}"
      },
      {
        "to" => "\x{178}",
        "from" => "\x{4f8}"
      },
      {
        "to" => "\x{ff}",
        "from" => "\x{4f9}"
      },
      {
        "to" => "\x{2b9}",
        "from" => "\x{42c}",
        "context" => {
          "after" => "\\p{IsUpper}"
        }
      },
      {
        "to" => "\x{2b9}",
        "from" => "\x{44c}"
      },
      {
        "to" => "\x{c8}",
        "from" => "\x{42d}"
      },
      {
        "to" => "\x{e8}",
        "from" => "\x{44d}"
      },
      {
        "to" => "\x{db}",
        "from" => "\x{42e}"
      },
      {
        "to" => "\x{fb}",
        "from" => "\x{44e}"
      },
      {
        "to" => "\x{c2}",
        "from" => "\x{42f}"
      },
      {
        "to" => "\x{e2}",
        "from" => "\x{44f}"
      },
      {
        "to" => "\x{11a}",
        "from" => "\x{48c}"
      },
      {
        "to" => "\x{11b}",
        "from" => "\x{48d}"
      },
      {
        "to" => "\x{1cd}",
        "from" => "\x{46a}"
      },
      {
        "to" => "\x{1ce}",
        "from" => "\x{46b}"
      },
      {
        "to" => "F\x{300}",
        "from" => "\x{472}"
      },
      {
        "to" => "f\x{300}",
        "from" => "\x{473}"
      },
      {
        "to" => "\x{1ef2}",
        "from" => "\x{474}"
      },
      {
        "to" => "\x{1ef3}",
        "from" => "\x{475}"
      },
      {
        "to" => "\x{d2}",
        "from" => "\x{4a8}"
      },
      {
        "to" => "\x{f2}",
        "from" => "\x{4a9}"
      },
      {
        "to" => "\x{2021}",
        "from" => "\x{4c0}"
      }
    ],
    "reverse" => "true"
  },
  "common_slv" => {
    "desc" => "Slovenian without diacritics",
    "name" => "Common SLV",
    "id" => "common_slv",
    "rules" => [
      {
        "to" => "C",
        "from" => "\x{10c}"
      },
      {
        "to" => "c",
        "from" => "\x{10d}"
      },
      {
        "to" => "S",
        "from" => "\x{160}"
      },
      {
        "to" => "s",
        "from" => "\x{161}"
      },
      {
        "to" => "Z",
        "from" => "\x{17d}"
      },
      {
        "to" => "z",
        "from" => "\x{17e}"
      }
    ],
    "reverse" => "false"
  },
  "iso_843" => {
    "desc" => "ISO 843:1997 TL (Type 1), Greek to Latin",
    "name" => "ISO 843",
    "id" => "iso_843",
    "rules" => [
      {
        "to" => "A",
        "from" => "\x{391}"
      },
      {
        "to" => "a",
        "from" => "\x{3b1}"
      },
      {
        "to" => "V",
        "from" => "\x{392}"
      },
      {
        "to" => "v",
        "from" => "\x{3b2}"
      },
      {
        "to" => "G",
        "from" => "\x{393}"
      },
      {
        "to" => "g",
        "from" => "\x{3b3}"
      },
      {
        "to" => "D",
        "from" => "\x{394}"
      },
      {
        "to" => "d",
        "from" => "\x{3b4}"
      },
      {
        "to" => "E",
        "from" => "\x{395}"
      },
      {
        "to" => "e",
        "from" => "\x{3b5}"
      },
      {
        "to" => "Z",
        "from" => "\x{396}"
      },
      {
        "to" => "z",
        "from" => "\x{3b6}"
      },
      {
        "to" => "\x{12a}",
        "from" => "\x{397}"
      },
      {
        "to" => "\x{12b}",
        "from" => "\x{3b7}"
      },
      {
        "to" => "Th",
        "from" => "\x{398}"
      },
      {
        "to" => "th",
        "from" => "\x{3b8}"
      },
      {
        "to" => "I",
        "from" => "\x{399}"
      },
      {
        "to" => "i",
        "from" => "\x{3b9}"
      },
      {
        "to" => "K",
        "from" => "\x{39a}"
      },
      {
        "to" => "k",
        "from" => "\x{3ba}"
      },
      {
        "to" => "L",
        "from" => "\x{39b}"
      },
      {
        "to" => "l",
        "from" => "\x{3bb}"
      },
      {
        "to" => "M",
        "from" => "\x{39c}"
      },
      {
        "to" => "m",
        "from" => "\x{3bc}"
      },
      {
        "to" => "N",
        "from" => "\x{39d}"
      },
      {
        "to" => "n",
        "from" => "\x{3bd}"
      },
      {
        "to" => "X",
        "from" => "\x{39e}"
      },
      {
        "to" => "x",
        "from" => "\x{3be}"
      },
      {
        "to" => "O",
        "from" => "\x{39f}"
      },
      {
        "to" => "o",
        "from" => "\x{3bf}"
      },
      {
        "to" => "P",
        "from" => "\x{3a0}"
      },
      {
        "to" => "p",
        "from" => "\x{3c0}"
      },
      {
        "to" => "R",
        "from" => "\x{3a1}"
      },
      {
        "to" => "r",
        "from" => "\x{3c1}"
      },
      {
        "to" => "S",
        "from" => "\x{3a3}"
      },
      {
        "to" => "s",
        "from" => "\x{3c2}"
      },
      {
        "to" => "s",
        "from" => "\x{3c3}"
      },
      {
        "to" => "T",
        "from" => "\x{3a4}"
      },
      {
        "to" => "t",
        "from" => "\x{3c4}"
      },
      {
        "to" => "Y",
        "from" => "\x{3a5}"
      },
      {
        "to" => "y",
        "from" => "\x{3c5}"
      },
      {
        "to" => "F",
        "from" => "\x{3a6}"
      },
      {
        "to" => "f",
        "from" => "\x{3c6}"
      },
      {
        "to" => "Ch",
        "from" => "\x{3a7}"
      },
      {
        "to" => "ch",
        "from" => "\x{3c7}"
      },
      {
        "to" => "Ps",
        "from" => "\x{3a8}"
      },
      {
        "to" => "ps",
        "from" => "\x{3c8}"
      },
      {
        "to" => "\x{14c}",
        "from" => "\x{3a9}"
      },
      {
        "to" => "\x{14d}",
        "from" => "\x{3c9}"
      },
      {
        "to" => "S",
        "from" => "\x{3da}"
      },
      {
        "to" => "s",
        "from" => "\x{3db}"
      },
      {
        "to" => "W",
        "from" => "\x{3dc}"
      },
      {
        "to" => "f",
        "from" => "\x{3dd}"
      },
      {
        "to" => "j",
        "from" => "\x{3f3}"
      },
      {
        "to" => "\x{b4}",
        "from" => "\x{384}"
      },
      {
        "to" => "\x{a8}\x{301}",
        "from" => "\x{385}"
      },
      {
        "to" => "\x{302}",
        "from" => "\x{342}"
      },
      {
        "to" => "\x{2bc}",
        "from" => "\x{343}"
      },
      {
        "to" => "\x{2bc}",
        "from" => "\x{313}"
      },
      {
        "to" => "h",
        "from" => "\x{314}"
      },
      {
        "to" => "\x{327}",
        "from" => "\x{345}"
      },
      {
        "to" => "\x{327}",
        "from" => "\x{345}"
      },
      {
        "to" => "\x{c1}",
        "from" => "\x{386}"
      },
      {
        "to" => "\x{e1}",
        "from" => "\x{3ac}"
      },
      {
        "to" => "\x{c9}",
        "from" => "\x{388}"
      },
      {
        "to" => "\x{e9}",
        "from" => "\x{3ad}"
      },
      {
        "to" => "\x{12a}\x{301}",
        "from" => "\x{389}"
      },
      {
        "to" => "\x{12b}\x{301}",
        "from" => "\x{3ae}"
      },
      {
        "to" => "\x{cd}",
        "from" => "\x{38a}"
      },
      {
        "to" => "\x{ed}",
        "from" => "\x{3af}"
      },
      {
        "to" => "\x{d3}",
        "from" => "\x{38c}"
      },
      {
        "to" => "\x{f3}",
        "from" => "\x{3cc}"
      },
      {
        "to" => "\x{dd}",
        "from" => "\x{38e}"
      },
      {
        "to" => "\x{fd}",
        "from" => "\x{3cd}"
      },
      {
        "to" => "\x{1e52}",
        "from" => "\x{38f}"
      },
      {
        "to" => "\x{1e53}",
        "from" => "\x{3ce}"
      },
      {
        "to" => "\x{cf}",
        "from" => "\x{3aa}"
      },
      {
        "to" => "\x{ef}",
        "from" => "\x{3ca}"
      },
      {
        "to" => "\x{178}",
        "from" => "\x{3ab}"
      },
      {
        "to" => "\x{ff}",
        "from" => "\x{3cb}"
      },
      {
        "to" => "\x{1e2f}",
        "from" => "\x{390}"
      },
      {
        "to" => "\x{ff}\x{301}",
        "from" => "\x{3b0}"
      },
      {
        "to" => "?",
        "from" => "\x{37e}",
        "context" => {
          "after" => "\\b"
        }
      },
      {
        "to" => "?",
        "from" => ";",
        "context" => {
          "after" => "\\b"
        }
      },
      {
        "to" => ";",
        "from" => "\x{b7}"
      },
      {
        "to" => "-",
        "from" => "\x{203f}"
      }
    ],
    "reverse" => "false"
  },
  "din_31634" => {
    "desc" => "DIN 31634:1982, Greek to Latin",
    "name" => "DIN 31634",
    "id" => "din_31634",
    "rules" => [
      {
        "to" => "AU",
        "from" => "\x{391}\x{3a5}"
      },
      {
        "to" => "au",
        "from" => "\x{3b1}\x{3c5}"
      },
      {
        "to" => "Au",
        "from" => "\x{391}\x{3c5}"
      },
      {
        "to" => "A\x{178}",
        "from" => "\x{391}\x{3ab}"
      },
      {
        "to" => "a\x{ff}",
        "from" => "\x{3b1}\x{3cb}"
      },
      {
        "to" => "NG",
        "from" => "\x{393}\x{393}"
      },
      {
        "to" => "ng",
        "from" => "\x{3b3}\x{3b3}"
      },
      {
        "to" => "Ng",
        "from" => "\x{393}\x{3b3}"
      },
      {
        "to" => "GK",
        "from" => "\x{393}\x{39a}",
        "context" => {
          "after" => "\\b"
        }
      },
      {
        "to" => "gk",
        "from" => "\x{3b3}\x{3ba}",
        "context" => {
          "after" => "\\b"
        }
      },
      {
        "to" => "Gk",
        "from" => "\x{393}\x{3ba}",
        "context" => {
          "after" => "\\b"
        }
      },
      {
        "to" => "NK",
        "from" => "\x{393}\x{39a}"
      },
      {
        "to" => "nk",
        "from" => "\x{3b3}\x{3ba}"
      },
      {
        "to" => "Nk",
        "from" => "\x{393}\x{3ba}"
      },
      {
        "to" => "NX",
        "from" => "\x{393}\x{39e}"
      },
      {
        "to" => "nx",
        "from" => "\x{3b3}\x{3be}"
      },
      {
        "to" => "Nx",
        "from" => "\x{393}\x{3be}"
      },
      {
        "to" => "nch",
        "from" => "\x{393}\x{3a7}"
      },
      {
        "to" => "nch",
        "from" => "\x{3b3}\x{3c7}"
      },
      {
        "to" => "Nch",
        "from" => "\x{393}\x{3c7}"
      },
      {
        "to" => "EU",
        "from" => "\x{395}\x{3a5}"
      },
      {
        "to" => "eu",
        "from" => "\x{3b5}\x{3c5}"
      },
      {
        "to" => "Eu",
        "from" => "\x{395}\x{3c5}"
      },
      {
        "to" => "\x{112}U",
        "from" => "\x{397}\x{3a5}"
      },
      {
        "to" => "\x{113}u",
        "from" => "\x{3b7}\x{3c5}"
      },
      {
        "to" => "\x{112}u",
        "from" => "\x{397}\x{3c5}"
      },
      {
        "to" => "U",
        "from" => "\x{39f}\x{3a5}"
      },
      {
        "to" => "u",
        "from" => "\x{3bf}\x{3c5}"
      },
      {
        "to" => "U",
        "from" => "\x{39f}\x{3c5}"
      },
      {
        "to" => "O\x{178}",
        "from" => "\x{39f}\x{3ab}"
      },
      {
        "to" => "o\x{ff}",
        "from" => "\x{3bf}\x{3cb}"
      },
      {
        "to" => "A",
        "from" => "\x{391}"
      },
      {
        "to" => "a",
        "from" => "\x{3b1}"
      },
      {
        "to" => "B",
        "from" => "\x{392}"
      },
      {
        "to" => "b",
        "from" => "\x{3b2}"
      },
      {
        "to" => "G",
        "from" => "\x{393}"
      },
      {
        "to" => "g",
        "from" => "\x{3b3}"
      },
      {
        "to" => "D",
        "from" => "\x{394}"
      },
      {
        "to" => "d",
        "from" => "\x{3b4}"
      },
      {
        "to" => "E",
        "from" => "\x{395}"
      },
      {
        "to" => "e",
        "from" => "\x{3b5}"
      },
      {
        "to" => "Z",
        "from" => "\x{396}"
      },
      {
        "to" => "z",
        "from" => "\x{3b6}"
      },
      {
        "to" => "\x{112}",
        "from" => "\x{397}"
      },
      {
        "to" => "\x{113}",
        "from" => "\x{3b7}"
      },
      {
        "to" => "Th",
        "from" => "\x{398}"
      },
      {
        "to" => "th",
        "from" => "\x{3b8}"
      },
      {
        "to" => "th",
        "from" => "\x{3d1}"
      },
      {
        "to" => "I",
        "from" => "\x{399}"
      },
      {
        "to" => "i",
        "from" => "\x{3b9}"
      },
      {
        "to" => "K",
        "from" => "\x{39a}"
      },
      {
        "to" => "k",
        "from" => "\x{3ba}"
      },
      {
        "to" => "L",
        "from" => "\x{39b}"
      },
      {
        "to" => "l",
        "from" => "\x{3bb}"
      },
      {
        "to" => "M",
        "from" => "\x{39c}"
      },
      {
        "to" => "m",
        "from" => "\x{3bc}"
      },
      {
        "to" => "N",
        "from" => "\x{39d}"
      },
      {
        "to" => "n",
        "from" => "\x{3bd}"
      },
      {
        "to" => "X",
        "from" => "\x{39e}"
      },
      {
        "to" => "x",
        "from" => "\x{3be}"
      },
      {
        "to" => "O",
        "from" => "\x{39f}"
      },
      {
        "to" => "o",
        "from" => "\x{3bf}"
      },
      {
        "to" => "P",
        "from" => "\x{3a0}"
      },
      {
        "to" => "p",
        "from" => "\x{3c0}"
      },
      {
        "to" => "R",
        "from" => "\x{3a1}"
      },
      {
        "to" => "r",
        "from" => "\x{3c1}"
      },
      {
        "to" => "S",
        "from" => "\x{3a3}"
      },
      {
        "to" => "s",
        "from" => "\x{3c3}"
      },
      {
        "to" => "s",
        "from" => "\x{3c2}",
        "context" => {
          "before" => "\\b"
        }
      },
      {
        "to" => "T",
        "from" => "\x{3a4}"
      },
      {
        "to" => "t",
        "from" => "\x{3c4}"
      },
      {
        "to" => "Y",
        "from" => "\x{3a5}"
      },
      {
        "to" => "y",
        "from" => "\x{3c5}"
      },
      {
        "to" => "Ph",
        "from" => "\x{3a6}"
      },
      {
        "to" => "ph",
        "from" => "\x{3c6}"
      },
      {
        "to" => "ph",
        "from" => "\x{3d5}"
      },
      {
        "to" => "Ch",
        "from" => "\x{3a7}"
      },
      {
        "to" => "ch",
        "from" => "\x{3c7}"
      },
      {
        "to" => "Ps",
        "from" => "\x{3a8}"
      },
      {
        "to" => "ps",
        "from" => "\x{3c8}"
      },
      {
        "to" => "\x{14c}",
        "from" => "\x{3a9}"
      },
      {
        "to" => "\x{14d}",
        "from" => "\x{3c9}"
      },
      {
        "to" => "A",
        "from" => "\x{386}"
      },
      {
        "to" => "a",
        "from" => "\x{3ac}"
      },
      {
        "to" => "E",
        "from" => "\x{388}"
      },
      {
        "to" => "e",
        "from" => "\x{3ad}"
      },
      {
        "to" => "\x{112}",
        "from" => "\x{389}"
      },
      {
        "to" => "\x{113}",
        "from" => "\x{3ae}"
      },
      {
        "to" => "I",
        "from" => "\x{38a}"
      },
      {
        "to" => "i",
        "from" => "\x{3af}"
      },
      {
        "to" => "I",
        "from" => "\x{3aa}"
      },
      {
        "to" => "i",
        "from" => "\x{3ca}"
      },
      {
        "to" => "i",
        "from" => "\x{390}"
      },
      {
        "to" => "O",
        "from" => "\x{38c}"
      },
      {
        "to" => "o",
        "from" => "\x{3cc}"
      },
      {
        "to" => "Y",
        "from" => "\x{38e}"
      },
      {
        "to" => "y",
        "from" => "\x{3cd}"
      },
      {
        "to" => "Y",
        "from" => "\x{3ab}"
      },
      {
        "to" => "y",
        "from" => "\x{3cb}"
      },
      {
        "to" => "y",
        "from" => "\x{3b0}"
      },
      {
        "to" => "\x{14c}",
        "from" => "\x{38f}"
      },
      {
        "to" => "\x{14d}",
        "from" => "\x{3ce}"
      },
      {
        "to" => "?",
        "from" => "\x{37e}"
      },
      {
        "to" => "?",
        "from" => ";"
      },
      {
        "to" => ";",
        "from" => "\x{b7}"
      },
      {
        "to" => "",
        "from" => "\x{384}"
      },
      {
        "to" => "",
        "from" => "\x{385}"
      },
      {
        "to" => "",
        "from" => "\x{342}"
      },
      {
        "to" => "",
        "from" => "\x{343}"
      },
      {
        "to" => "",
        "from" => "\x{313}"
      },
      {
        "to" => "",
        "from" => "\x{314}"
      },
      {
        "to" => "",
        "from" => "\x{345}"
      },
      {
        "to" => "",
        "from" => "\x{345}"
      }
    ],
    "reverse" => "false"
  },
  "common_ces" => {
    "desc" => "Czech without diacritics",
    "name" => "Common CES",
    "id" => "common_ces",
    "rules" => [
      {
        "to" => "A",
        "from" => "\x{c1}"
      },
      {
        "to" => "a",
        "from" => "\x{e1}"
      },
      {
        "to" => "C",
        "from" => "\x{10c}"
      },
      {
        "to" => "c",
        "from" => "\x{10d}"
      },
      {
        "to" => "D",
        "from" => "\x{10e}"
      },
      {
        "to" => "d",
        "from" => "\x{10f}"
      },
      {
        "to" => "d",
        "from" => "d\x{30c}"
      },
      {
        "to" => "E",
        "from" => "\x{c9}"
      },
      {
        "to" => "e",
        "from" => "\x{e9}"
      },
      {
        "to" => "E",
        "from" => "\x{11a}"
      },
      {
        "to" => "e",
        "from" => "\x{11b}"
      },
      {
        "to" => "I",
        "from" => "\x{cd}"
      },
      {
        "to" => "i",
        "from" => "\x{ed}"
      },
      {
        "to" => "N",
        "from" => "\x{147}"
      },
      {
        "to" => "n",
        "from" => "\x{148}"
      },
      {
        "to" => "O",
        "from" => "\x{d3}"
      },
      {
        "to" => "o",
        "from" => "\x{f3}"
      },
      {
        "to" => "R",
        "from" => "\x{158}"
      },
      {
        "to" => "r",
        "from" => "\x{159}"
      },
      {
        "to" => "S",
        "from" => "\x{160}"
      },
      {
        "to" => "s",
        "from" => "\x{161}"
      },
      {
        "to" => "T",
        "from" => "\x{164}"
      },
      {
        "to" => "t",
        "from" => "\x{165}"
      },
      {
        "to" => "t",
        "from" => "t\x{30c};"
      },
      {
        "to" => "U",
        "from" => "\x{da}"
      },
      {
        "to" => "u",
        "from" => "\x{fa}"
      },
      {
        "to" => "U",
        "from" => "\x{16e}"
      },
      {
        "to" => "u",
        "from" => "\x{16f}"
      },
      {
        "to" => "Y",
        "from" => "\x{dd}"
      },
      {
        "to" => "y",
        "from" => "\x{fd}"
      },
      {
        "to" => "Z",
        "from" => "\x{17d}"
      },
      {
        "to" => "z",
        "from" => "\x{17e}"
      }
    ],
    "reverse" => "false"
  },
  "din_1460_ukr" => {
    "desc" => "DIN 1460:1982, Cyrillic to Latin, Ukrainian",
    "name" => "DIN 1460 UKR",
    "id" => "din_1460_ukr",
    "rules" => [
      {
        "to" => "je",
        "from" => "\x{454}"
      },
      {
        "to" => "JE",
        "from" => "\x{404}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Je",
        "from" => "\x{404}"
      },
      {
        "to" => "ch",
        "from" => "\x{445}"
      },
      {
        "to" => "CH",
        "from" => "\x{425}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ch",
        "from" => "\x{425}"
      },
      {
        "to" => "\x{161}\x{10d}",
        "from" => "\x{449}"
      },
      {
        "to" => "\x{160}\x{10c}",
        "from" => "\x{429}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "\x{160}\x{10d}",
        "from" => "\x{429}"
      },
      {
        "to" => "ju",
        "from" => "\x{44e}"
      },
      {
        "to" => "JU",
        "from" => "\x{42e}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ju",
        "from" => "\x{42e}"
      },
      {
        "to" => "ja",
        "from" => "\x{44f}"
      },
      {
        "to" => "JA",
        "from" => "\x{42f}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ja",
        "from" => "\x{42f}"
      },
      {
        "to" => "J-",
        "from" => "\x{419}",
        "context" => {
          "before" => "[aueAUE\x{430}\x{443}\x{435}\x{410}\x{423}\x{415}]"
        }
      },
      {
        "to" => "j-",
        "from" => "\x{439}",
        "context" => {
          "before" => "[aue\x{430}\x{443}\x{435}]"
        }
      },
      {
        "to" => "\x{160}-",
        "from" => "\x{428}",
        "context" => {
          "before" => "[\x{10c}\x{10d}\x{427}\x{447}]"
        }
      },
      {
        "to" => "\x{161}-",
        "from" => "\x{448}",
        "context" => {
          "before" => "[\x{10d}\x{447}]"
        }
      },
      {
        "to" => "c-",
        "from" => "\x{446}",
        "context" => {
          "before" => "[h\x{433}]"
        }
      },
      {
        "to" => "C-",
        "from" => "\x{426}",
        "context" => {
          "before" => "[hH\x{433}\x{413}]"
        }
      },
      {
        "to" => "a",
        "from" => "\x{430}"
      },
      {
        "to" => "A",
        "from" => "\x{410}"
      },
      {
        "to" => "b",
        "from" => "\x{431}"
      },
      {
        "to" => "B",
        "from" => "\x{411}"
      },
      {
        "to" => "v",
        "from" => "\x{432}"
      },
      {
        "to" => "V",
        "from" => "\x{412}"
      },
      {
        "to" => "h",
        "from" => "\x{433}"
      },
      {
        "to" => "H",
        "from" => "\x{413}"
      },
      {
        "to" => "g",
        "from" => "\x{491}"
      },
      {
        "to" => "G",
        "from" => "\x{490}"
      },
      {
        "to" => "d",
        "from" => "\x{434}"
      },
      {
        "to" => "D",
        "from" => "\x{414}"
      },
      {
        "to" => "e",
        "from" => "\x{435}"
      },
      {
        "to" => "E",
        "from" => "\x{415}"
      },
      {
        "to" => "\x{17e}",
        "from" => "\x{436}"
      },
      {
        "to" => "\x{17d}",
        "from" => "\x{416}"
      },
      {
        "to" => "z",
        "from" => "\x{437}"
      },
      {
        "to" => "Z",
        "from" => "\x{417}"
      },
      {
        "to" => "y",
        "from" => "\x{438}"
      },
      {
        "to" => "Y",
        "from" => "\x{418}"
      },
      {
        "to" => "i",
        "from" => "\x{456}"
      },
      {
        "to" => "I",
        "from" => "\x{406}"
      },
      {
        "to" => "\x{ef}",
        "from" => "\x{457}"
      },
      {
        "to" => "\x{cf}",
        "from" => "\x{407}"
      },
      {
        "to" => "j",
        "from" => "\x{439}"
      },
      {
        "to" => "J",
        "from" => "\x{419}"
      },
      {
        "to" => "k",
        "from" => "\x{43a}"
      },
      {
        "to" => "K",
        "from" => "\x{41a}"
      },
      {
        "to" => "l",
        "from" => "\x{43b}"
      },
      {
        "to" => "L",
        "from" => "\x{41b}"
      },
      {
        "to" => "m",
        "from" => "\x{43c}"
      },
      {
        "to" => "M",
        "from" => "\x{41c}"
      },
      {
        "to" => "n",
        "from" => "\x{43d}"
      },
      {
        "to" => "N",
        "from" => "\x{41d}"
      },
      {
        "to" => "o",
        "from" => "\x{43e}"
      },
      {
        "to" => "O",
        "from" => "\x{41e}"
      },
      {
        "to" => "p",
        "from" => "\x{43f}"
      },
      {
        "to" => "P",
        "from" => "\x{41f}"
      },
      {
        "to" => "r",
        "from" => "\x{440}"
      },
      {
        "to" => "R",
        "from" => "\x{420}"
      },
      {
        "to" => "s",
        "from" => "\x{441}"
      },
      {
        "to" => "S",
        "from" => "\x{421}"
      },
      {
        "to" => "t",
        "from" => "\x{442}"
      },
      {
        "to" => "T",
        "from" => "\x{422}"
      },
      {
        "to" => "u",
        "from" => "\x{443}"
      },
      {
        "to" => "U",
        "from" => "\x{423}"
      },
      {
        "to" => "f",
        "from" => "\x{444}"
      },
      {
        "to" => "F",
        "from" => "\x{424}"
      },
      {
        "to" => "c",
        "from" => "\x{446}"
      },
      {
        "to" => "C",
        "from" => "\x{426}"
      },
      {
        "to" => "\x{10d}",
        "from" => "\x{447}"
      },
      {
        "to" => "\x{10c}",
        "from" => "\x{427}"
      },
      {
        "to" => "\x{161}",
        "from" => "\x{448}"
      },
      {
        "to" => "\x{160}",
        "from" => "\x{428}"
      },
      {
        "to" => "'",
        "from" => "\x{42c}",
        "context" => {
          "after" => "\\p{IsUpper}"
        }
      },
      {
        "to" => "'",
        "from" => "\x{44c}"
      },
      {
        "to" => "\x{2ee}",
        "from" => "\x{2bc}"
      }
    ],
    "reverse" => "true"
  },
  "common_classical_mon" => {
    "desc" => "Classical Mongolian Script to Latin",
    "name" => "Common Classical MON",
    "id" => "common_classical_mon",
    "rules" => [
      {
        "to" => "a",
        "from" => "\x{1820}"
      },
      {
        "to" => "e",
        "from" => "\x{1821}"
      },
      {
        "to" => "i",
        "from" => "\x{1822}"
      },
      {
        "to" => "o",
        "from" => "\x{1823}"
      },
      {
        "to" => "u",
        "from" => "\x{1824}"
      },
      {
        "to" => "\x{f6}",
        "from" => "\x{1825}"
      },
      {
        "to" => "\x{fc}",
        "from" => "\x{1826}"
      },
      {
        "to" => "\x{113}",
        "from" => "\x{1827}"
      },
      {
        "to" => "ng",
        "from" => "\x{1829}"
      },
      {
        "to" => "n",
        "from" => "\x{1828}"
      },
      {
        "to" => "b",
        "from" => "\x{182a}"
      },
      {
        "to" => "p",
        "from" => "\x{182b}"
      },
      {
        "to" => "k",
        "from" => "\x{182c}",
        "context" => {
          "before" => "i"
        }
      },
      {
        "to" => "q",
        "from" => "\x{182c}",
        "context" => {
          "before" => "\x{180e}?[aou]"
        }
      },
      {
        "to" => "q",
        "from" => "\x{182c}",
        "context" => {
          "after" => "[aou]"
        }
      },
      {
        "to" => "k",
        "from" => "\x{182c}",
        "context" => {
          "before" => "[\x{fc}e\x{f6}]"
        }
      },
      {
        "to" => "k",
        "from" => "\x{182c}",
        "context" => {
          "after" => "[\x{fc}e\x{f6}]"
        }
      },
      {
        "to" => "q",
        "from" => "\x{182c}"
      },
      {
        "to" => "k",
        "from" => "\x{182c}"
      },
      {
        "to" => "g",
        "from" => "\x{182d}",
        "context" => {
          "before" => "i\\s"
        }
      },
      {
        "to" => "\x{263}",
        "from" => "\x{182d}",
        "context" => {
          "before" => "\x{180e}?[aou]"
        }
      },
      {
        "to" => "\x{263}",
        "from" => "\x{182d}",
        "context" => {
          "after" => "[aou]"
        }
      },
      {
        "to" => "g",
        "from" => "\x{182d}",
        "context" => {
          "before" => "[\x{fc}e\x{f6}]"
        }
      },
      {
        "to" => "g",
        "from" => "\x{182d}",
        "context" => {
          "after" => "[\x{fc}e\x{f6}]"
        }
      },
      {
        "to" => "\x{263}",
        "from" => "\x{182d}",
        "context" => {
          "after" => "[aou]."
        }
      },
      {
        "to" => "\x{263}",
        "from" => "\x{182d}",
        "context" => {
          "after" => "[aou].i"
        }
      },
      {
        "to" => "\x{263}",
        "from" => "\x{182d}",
        "context" => {
          "after" => "[aou]..i"
        }
      },
      {
        "to" => "\x{263}",
        "from" => "\x{182d}",
        "context" => {
          "before" => ".[aou]"
        }
      },
      {
        "to" => "g",
        "from" => "\x{182d}",
        "context" => {
          "before" => ".[\x{fc}e\x{f6}]"
        }
      },
      {
        "to" => "g",
        "from" => "\x{182d}"
      },
      {
        "to" => "\x{263}",
        "from" => "\x{182d}"
      },
      {
        "to" => "m",
        "from" => "\x{182e}"
      },
      {
        "to" => "s",
        "from" => "\x{1830}"
      },
      {
        "to" => "\x{161}",
        "from" => "\x{1831}"
      },
      {
        "to" => "t",
        "from" => "\x{1832}"
      },
      {
        "to" => "d",
        "from" => "\x{1833}"
      },
      {
        "to" => "\x{10d}",
        "from" => "\x{1834}"
      },
      {
        "to" => "j",
        "from" => "\x{1835}"
      },
      {
        "to" => "y",
        "from" => "\x{1836}"
      },
      {
        "to" => "r",
        "from" => "\x{1837}"
      },
      {
        "to" => "v",
        "from" => "\x{1838}"
      },
      {
        "to" => "w",
        "from" => "\x{1838}"
      },
      {
        "to" => "f",
        "from" => "\x{1839}"
      },
      {
        "to" => "\x{1e33}",
        "from" => "\x{183a}"
      },
      {
        "to" => "\x{1e9}",
        "from" => "\x{183b}"
      },
      {
        "to" => "\x{17e}",
        "from" => "\x{183f}"
      },
      {
        "to" => "lh",
        "from" => "\x{1840}"
      },
      {
        "to" => "l",
        "from" => "\x{182f}"
      },
      {
        "to" => "zh",
        "from" => "\x{1841}"
      },
      {
        "to" => "z",
        "from" => "\x{183d}"
      },
      {
        "to" => "ch",
        "from" => "\x{1842}"
      },
      {
        "to" => "c",
        "from" => "\x{183c}"
      },
      {
        "to" => "h",
        "from" => "\x{183e}"
      },
      {
        "to" => "\x{a7}",
        "from" => "\x{1800}"
      },
      {
        "to" => "\x{2026}",
        "from" => "\x{1801}"
      },
      {
        "to" => ",",
        "from" => "\x{1802}"
      },
      {
        "to" => ".",
        "from" => "\x{1803}"
      },
      {
        "to" => ":",
        "from" => "\x{1804}"
      },
      {
        "to" => "\x{b6}",
        "from" => "\x{1805}"
      },
      {
        "to" => "-",
        "from" => "\x{180e}"
      },
      {
        "to" => 0,
        "from" => "\x{1810}"
      },
      {
        "to" => 1,
        "from" => "\x{1811}"
      },
      {
        "to" => 2,
        "from" => "\x{1812}"
      },
      {
        "to" => 3,
        "from" => "\x{1813}"
      },
      {
        "to" => 4,
        "from" => "\x{1814}"
      },
      {
        "to" => 5,
        "from" => "\x{1815}"
      },
      {
        "to" => 6,
        "from" => "\x{1816}"
      },
      {
        "to" => 7,
        "from" => "\x{1817}"
      },
      {
        "to" => 8,
        "from" => "\x{1818}"
      },
      {
        "to" => 9,
        "from" => "\x{1819}"
      }
    ],
    "reverse" => "true"
  },
  "din_1460_bul" => {
    "desc" => "DIN 1460:1982, Cyrillic to Latin, Bulgarian",
    "name" => "DIN 1460 BUL",
    "id" => "din_1460_bul",
    "rules" => [
      {
        "to" => "\x{160}T",
        "from" => "\x{429}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "\x{160}t",
        "from" => "\x{429}"
      },
      {
        "to" => "\x{161}t",
        "from" => "\x{449}"
      },
      {
        "to" => "JU",
        "from" => "\x{42e}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ju",
        "from" => "\x{42e}"
      },
      {
        "to" => "ju",
        "from" => "\x{44e}"
      },
      {
        "to" => "JA",
        "from" => "\x{42f}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ja",
        "from" => "\x{42f}"
      },
      {
        "to" => "ja",
        "from" => "\x{44f}"
      },
      {
        "to" => "CH",
        "from" => "\x{425}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ch",
        "from" => "\x{425}"
      },
      {
        "to" => "ch",
        "from" => "\x{445}"
      },
      {
        "to" => "J-",
        "from" => "\x{419}",
        "context" => {
          "before" => "[auAU\x{430}\x{443}\x{410}\x{423}]"
        }
      },
      {
        "to" => "j-",
        "from" => "\x{439}",
        "context" => {
          "before" => "[au\x{430}\x{443}]"
        }
      },
      {
        "to" => "\x{160}-",
        "from" => "\x{428}",
        "context" => {
          "before" => "[tT\x{442}\x{422}]"
        }
      },
      {
        "to" => "\x{161}-",
        "from" => "\x{448}",
        "context" => {
          "before" => "[t\x{442}]"
        }
      },
      {
        "to" => "A",
        "from" => "\x{410}"
      },
      {
        "to" => "a",
        "from" => "\x{430}"
      },
      {
        "to" => "B",
        "from" => "\x{411}"
      },
      {
        "to" => "b",
        "from" => "\x{431}"
      },
      {
        "to" => "V",
        "from" => "\x{412}"
      },
      {
        "to" => "v",
        "from" => "\x{432}"
      },
      {
        "to" => "G",
        "from" => "\x{413}"
      },
      {
        "to" => "g",
        "from" => "\x{433}"
      },
      {
        "to" => "D",
        "from" => "\x{414}"
      },
      {
        "to" => "d",
        "from" => "\x{434}"
      },
      {
        "to" => "E",
        "from" => "\x{415}"
      },
      {
        "to" => "e",
        "from" => "\x{435}"
      },
      {
        "to" => "\x{17d}",
        "from" => "\x{416}"
      },
      {
        "to" => "\x{17e}",
        "from" => "\x{436}"
      },
      {
        "to" => "Z",
        "from" => "\x{417}"
      },
      {
        "to" => "z",
        "from" => "\x{437}"
      },
      {
        "to" => "I",
        "from" => "\x{418}"
      },
      {
        "to" => "i",
        "from" => "\x{438}"
      },
      {
        "to" => "J",
        "from" => "\x{419}"
      },
      {
        "to" => "j",
        "from" => "\x{439}"
      },
      {
        "to" => "K",
        "from" => "\x{41a}"
      },
      {
        "to" => "k",
        "from" => "\x{43a}"
      },
      {
        "to" => "L",
        "from" => "\x{41b}"
      },
      {
        "to" => "l",
        "from" => "\x{43b}"
      },
      {
        "to" => "M",
        "from" => "\x{41c}"
      },
      {
        "to" => "m",
        "from" => "\x{43c}"
      },
      {
        "to" => "N",
        "from" => "\x{41d}"
      },
      {
        "to" => "n",
        "from" => "\x{43d}"
      },
      {
        "to" => "O",
        "from" => "\x{41e}"
      },
      {
        "to" => "o",
        "from" => "\x{43e}"
      },
      {
        "to" => "P",
        "from" => "\x{41f}"
      },
      {
        "to" => "p",
        "from" => "\x{43f}"
      },
      {
        "to" => "R",
        "from" => "\x{420}"
      },
      {
        "to" => "r",
        "from" => "\x{440}"
      },
      {
        "to" => "T",
        "from" => "\x{422}"
      },
      {
        "to" => "t",
        "from" => "\x{442}"
      },
      {
        "to" => "U",
        "from" => "\x{423}"
      },
      {
        "to" => "u",
        "from" => "\x{443}"
      },
      {
        "to" => "F",
        "from" => "\x{424}"
      },
      {
        "to" => "f",
        "from" => "\x{444}"
      },
      {
        "to" => "C",
        "from" => "\x{426}"
      },
      {
        "to" => "c",
        "from" => "\x{446}"
      },
      {
        "to" => "S",
        "from" => "\x{421}"
      },
      {
        "to" => "s",
        "from" => "\x{441}"
      },
      {
        "to" => "\x{10c}",
        "from" => "\x{427}"
      },
      {
        "to" => "\x{10d}",
        "from" => "\x{447}"
      },
      {
        "to" => "\x{160}",
        "from" => "\x{428}"
      },
      {
        "to" => "\x{161}",
        "from" => "\x{448}"
      },
      {
        "to" => "\x{102}",
        "from" => "\x{42a}"
      },
      {
        "to" => "\x{103}",
        "from" => "\x{44a}"
      },
      {
        "to" => "'",
        "from" => "\x{42c}",
        "context" => {
          "after" => "\\p{IsUpper}"
        }
      },
      {
        "to" => "'",
        "from" => "\x{44c}"
      }
    ],
    "reverse" => "true"
  },
  "ala-lc_rus" => {
    "desc" => "ALA-LC:1997, Cyrillic to Latin, Russian",
    "name" => "ALA-LC RUS",
    "id" => "ala-lc_rus",
    "rules" => [
      {
        "to" => "A",
        "from" => "\x{410}"
      },
      {
        "to" => "B",
        "from" => "\x{411}"
      },
      {
        "to" => "V",
        "from" => "\x{412}"
      },
      {
        "to" => "G",
        "from" => "\x{413}"
      },
      {
        "to" => "D",
        "from" => "\x{414}"
      },
      {
        "to" => "E",
        "from" => "\x{415}"
      },
      {
        "to" => "\x{cb}",
        "from" => "\x{401}"
      },
      {
        "to" => "Zh",
        "from" => "\x{416}"
      },
      {
        "to" => "Z",
        "from" => "\x{417}"
      },
      {
        "to" => "I",
        "from" => "\x{418}"
      },
      {
        "to" => "\x{12a}",
        "from" => "\x{406}"
      },
      {
        "to" => "\x{12c}",
        "from" => "\x{419}"
      },
      {
        "to" => "K",
        "from" => "\x{41a}"
      },
      {
        "to" => "L",
        "from" => "\x{41b}"
      },
      {
        "to" => "M",
        "from" => "\x{41c}"
      },
      {
        "to" => "N",
        "from" => "\x{41d}"
      },
      {
        "to" => "O",
        "from" => "\x{41e}"
      },
      {
        "to" => "P",
        "from" => "\x{41f}"
      },
      {
        "to" => "R",
        "from" => "\x{420}"
      },
      {
        "to" => "S",
        "from" => "\x{421}"
      },
      {
        "to" => "T",
        "from" => "\x{422}"
      },
      {
        "to" => "U",
        "from" => "\x{423}"
      },
      {
        "to" => "F",
        "from" => "\x{424}"
      },
      {
        "to" => "Kh",
        "from" => "\x{425}"
      },
      {
        "to" => "TS",
        "from" => "\x{426}"
      },
      {
        "to" => "Ch",
        "from" => "\x{427}"
      },
      {
        "to" => "Ch",
        "from" => "\x{427}"
      },
      {
        "to" => "Sh",
        "from" => "\x{428}"
      },
      {
        "to" => "Shch",
        "from" => "\x{429}"
      },
      {
        "to" => "",
        "from" => "\x{42a}",
        "context" => {
          "before" => "\\b"
        }
      },
      {
        "to" => "\x{2033}",
        "from" => "\x{42a}"
      },
      {
        "to" => "Y",
        "from" => "\x{42b}"
      },
      {
        "to" => "\x{2032}",
        "from" => "\x{42c}"
      },
      {
        "to" => "IE",
        "from" => "\x{462}"
      },
      {
        "to" => "\x{116}",
        "from" => "\x{42d}"
      },
      {
        "to" => "IU",
        "from" => "\x{42e}"
      },
      {
        "to" => "IA",
        "from" => "\x{42f}"
      },
      {
        "to" => "\x{118}",
        "from" => "\x{466}"
      },
      {
        "to" => "\x{1e1e}",
        "from" => "\x{4e8}"
      },
      {
        "to" => "\x{1e8e}",
        "from" => "\x{474}"
      },
      {
        "to" => "a",
        "from" => "\x{430}"
      },
      {
        "to" => "b",
        "from" => "\x{431}"
      },
      {
        "to" => "v",
        "from" => "\x{432}"
      },
      {
        "to" => "g",
        "from" => "\x{433}"
      },
      {
        "to" => "d",
        "from" => "\x{434}"
      },
      {
        "to" => "e",
        "from" => "\x{435}"
      },
      {
        "to" => "\x{eb}",
        "from" => "\x{451}"
      },
      {
        "to" => "zh",
        "from" => "\x{436}"
      },
      {
        "to" => "z",
        "from" => "\x{437}"
      },
      {
        "to" => "i",
        "from" => "\x{438}"
      },
      {
        "to" => "\x{12b}",
        "from" => "\x{456}"
      },
      {
        "to" => "\x{12d}",
        "from" => "\x{439}"
      },
      {
        "to" => "k",
        "from" => "\x{43a}"
      },
      {
        "to" => "l",
        "from" => "\x{43b}"
      },
      {
        "to" => "m",
        "from" => "\x{43c}"
      },
      {
        "to" => "n",
        "from" => "\x{43d}"
      },
      {
        "to" => "o",
        "from" => "\x{43e}"
      },
      {
        "to" => "p",
        "from" => "\x{43f}"
      },
      {
        "to" => "r",
        "from" => "\x{440}"
      },
      {
        "to" => "s",
        "from" => "\x{441}"
      },
      {
        "to" => "t",
        "from" => "\x{442}"
      },
      {
        "to" => "u",
        "from" => "\x{443}"
      },
      {
        "to" => "f",
        "from" => "\x{444}"
      },
      {
        "to" => "kh",
        "from" => "\x{445}"
      },
      {
        "to" => "ts",
        "from" => "\x{446}"
      },
      {
        "to" => "ch",
        "from" => "\x{447}"
      },
      {
        "to" => "sh",
        "from" => "\x{448}"
      },
      {
        "to" => "shch",
        "from" => "\x{449}"
      },
      {
        "to" => "",
        "from" => "\x{44a}",
        "context" => {
          "before" => "\\b"
        }
      },
      {
        "to" => "\x{2033}",
        "from" => "\x{44a}"
      },
      {
        "to" => "y",
        "from" => "\x{44b}"
      },
      {
        "to" => "\x{2032}",
        "from" => "\x{44c}"
      },
      {
        "to" => "ie",
        "from" => "\x{463}"
      },
      {
        "to" => "\x{117}",
        "from" => "\x{44d}"
      },
      {
        "to" => "iu",
        "from" => "\x{44e}"
      },
      {
        "to" => "ia",
        "from" => "\x{44f}"
      },
      {
        "to" => "\x{119}",
        "from" => "\x{467}"
      },
      {
        "to" => "\x{1e1f}",
        "from" => "\x{4e9}"
      },
      {
        "to" => "\x{1e8f}",
        "from" => "\x{475}"
      }
    ],
    "reverse" => "false"
  },
  "common_deu" => {
    "desc" => "German umlauts",
    "name" => "Common DEU",
    "id" => "common_deu",
    "rules" => [
      {
        "to" => "Ae",
        "from" => "\x{c4}"
      },
      {
        "to" => "ae",
        "from" => "\x{e4}"
      },
      {
        "to" => "Oe",
        "from" => "\x{d6}"
      },
      {
        "to" => "oe",
        "from" => "\x{f6}"
      },
      {
        "to" => "Ue",
        "from" => "\x{dc}"
      },
      {
        "to" => "ue",
        "from" => "\x{fc}"
      },
      {
        "to" => "SS",
        "from" => "\x{df}",
        "context" => {
          "after" => "\\p{IsUpper}"
        }
      },
      {
        "to" => "ss",
        "from" => "\x{df}"
      }
    ],
    "reverse" => "false"
  },
  "gost_7.79_rus" => {
    "desc" => "GOST 7.79:2000, Cyrillic to Latin, Russian",
    "name" => "GOST 7.79 RUS",
    "id" => "gost_7.79_rus",
    "rules" => [
      {
        "to" => "c",
        "from" => "\x{446}",
        "context" => {
          "before" => "[iejy\x{438}\x{435}\x{439}\x{44b}\x{44e}\x{44f}\x{44d}\x{451}]"
        }
      },
      {
        "to" => "C",
        "from" => "\x{426}",
        "context" => {
          "before" => "[IEJY\x{418}\x{415}\x{419}\x{42b}\x{42e}\x{42f}\x{401}\x{42d}]"
        }
      },
      {
        "to" => "cz",
        "from" => "\x{446}"
      },
      {
        "to" => "CZ",
        "from" => "\x{426}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Cz",
        "from" => "\x{426}"
      },
      {
        "to" => "shh",
        "from" => "\x{449}"
      },
      {
        "to" => "SHH",
        "from" => "\x{429}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Shh",
        "from" => "\x{429}"
      },
      {
        "to" => "yo",
        "from" => "\x{451}"
      },
      {
        "to" => "YO",
        "from" => "\x{401}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Yo",
        "from" => "\x{401}"
      },
      {
        "to" => "zh",
        "from" => "\x{436}"
      },
      {
        "to" => "ZH",
        "from" => "\x{416}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Zh",
        "from" => "\x{416}"
      },
      {
        "to" => "ch",
        "from" => "\x{447}"
      },
      {
        "to" => "CH",
        "from" => "\x{427}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ch",
        "from" => "\x{427}"
      },
      {
        "to" => "sh",
        "from" => "\x{448}"
      },
      {
        "to" => "SH",
        "from" => "\x{428}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Sh",
        "from" => "\x{428}"
      },
      {
        "to" => "yu",
        "from" => "\x{44e}"
      },
      {
        "to" => "YU",
        "from" => "\x{42e}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Yu",
        "from" => "\x{42e}"
      },
      {
        "to" => "ya",
        "from" => "\x{44f}"
      },
      {
        "to" => "YA",
        "from" => "\x{42f}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ya",
        "from" => "\x{42f}"
      },
      {
        "to" => "``",
        "from" => "\x{44a}"
      },
      {
        "to" => "``",
        "from" => "\x{42a}",
        "context" => {
          "after" => "\\p{IsUpper}",
          "before" => "([^\\p{IsWord}]|\$)"
        }
      },
      {
        "to" => "y'",
        "from" => "\x{44b}"
      },
      {
        "to" => "Y'",
        "from" => "\x{42b}"
      },
      {
        "to" => "e`",
        "from" => "\x{44d}"
      },
      {
        "to" => "E`",
        "from" => "\x{42d}"
      },
      {
        "to" => "a",
        "from" => "\x{430}"
      },
      {
        "to" => "A",
        "from" => "\x{410}"
      },
      {
        "to" => "b",
        "from" => "\x{431}"
      },
      {
        "to" => "B",
        "from" => "\x{411}"
      },
      {
        "to" => "v",
        "from" => "\x{432}"
      },
      {
        "to" => "V",
        "from" => "\x{412}"
      },
      {
        "to" => "g",
        "from" => "\x{433}"
      },
      {
        "to" => "G",
        "from" => "\x{413}"
      },
      {
        "to" => "d",
        "from" => "\x{434}"
      },
      {
        "to" => "D",
        "from" => "\x{414}"
      },
      {
        "to" => "e",
        "from" => "\x{435}"
      },
      {
        "to" => "E",
        "from" => "\x{415}"
      },
      {
        "to" => "z",
        "from" => "\x{437}"
      },
      {
        "to" => "Z",
        "from" => "\x{417}"
      },
      {
        "to" => "i",
        "from" => "\x{438}"
      },
      {
        "to" => "I",
        "from" => "\x{418}"
      },
      {
        "to" => "j",
        "from" => "\x{439}"
      },
      {
        "to" => "J",
        "from" => "\x{419}"
      },
      {
        "to" => "k",
        "from" => "\x{43a}"
      },
      {
        "to" => "K",
        "from" => "\x{41a}"
      },
      {
        "to" => "l",
        "from" => "\x{43b}"
      },
      {
        "to" => "L",
        "from" => "\x{41b}"
      },
      {
        "to" => "m",
        "from" => "\x{43c}"
      },
      {
        "to" => "M",
        "from" => "\x{41c}"
      },
      {
        "to" => "n",
        "from" => "\x{43d}"
      },
      {
        "to" => "N",
        "from" => "\x{41d}"
      },
      {
        "to" => "o",
        "from" => "\x{43e}"
      },
      {
        "to" => "O",
        "from" => "\x{41e}"
      },
      {
        "to" => "p",
        "from" => "\x{43f}"
      },
      {
        "to" => "P",
        "from" => "\x{41f}"
      },
      {
        "to" => "r",
        "from" => "\x{440}"
      },
      {
        "to" => "R",
        "from" => "\x{420}"
      },
      {
        "to" => "s",
        "from" => "\x{441}"
      },
      {
        "to" => "S",
        "from" => "\x{421}"
      },
      {
        "to" => "t",
        "from" => "\x{442}"
      },
      {
        "to" => "T",
        "from" => "\x{422}"
      },
      {
        "to" => "u",
        "from" => "\x{443}"
      },
      {
        "to" => "U",
        "from" => "\x{423}"
      },
      {
        "to" => "f",
        "from" => "\x{444}"
      },
      {
        "to" => "F",
        "from" => "\x{424}"
      },
      {
        "to" => "x",
        "from" => "\x{445}"
      },
      {
        "to" => "X",
        "from" => "\x{425}"
      },
      {
        "to" => "`",
        "from" => "\x{42c}",
        "context" => {
          "after" => "\\p{IsUpper}"
        }
      },
      {
        "to" => "`",
        "from" => "\x{44c}"
      },
      {
        "to" => "#",
        "from" => "\x{2116}"
      }
    ],
    "reverse" => "true"
  },
  "greeklish" => {
    "desc" => "Greeklish (Phonetic), Greek to Latin",
    "name" => "Greeklish",
    "id" => "greeklish",
    "rules" => [
      {
        "to" => "i",
        "from" => "\x{3b5}\x{3b9}"
      },
      {
        "to" => "i",
        "from" => "\x{3ad}\x{3b9}"
      },
      {
        "to" => "i",
        "from" => "\x{3b5}\x{3af}"
      },
      {
        "to" => "ef",
        "from" => "\x{3b5}\x{3c5}"
      },
      {
        "to" => "ef",
        "from" => "\x{3ad}\x{3c5}"
      },
      {
        "to" => "ef",
        "from" => "\x{3b5}\x{3cd}"
      },
      {
        "to" => "u",
        "from" => "\x{3bf}\x{3c5}"
      },
      {
        "to" => "u",
        "from" => "\x{3bf}\x{3cd}"
      },
      {
        "to" => "u",
        "from" => "\x{3cc}\x{3c5}"
      },
      {
        "to" => "A",
        "from" => "\x{391}"
      },
      {
        "to" => "a",
        "from" => "\x{3b1}"
      },
      {
        "to" => "A",
        "from" => "\x{386}"
      },
      {
        "to" => "a",
        "from" => "\x{3ac}"
      },
      {
        "to" => "V",
        "from" => "\x{392}"
      },
      {
        "to" => "v",
        "from" => "\x{3b2}"
      },
      {
        "to" => "Y",
        "from" => "\x{393}"
      },
      {
        "to" => "y",
        "from" => "\x{3b3}"
      },
      {
        "to" => "D",
        "from" => "\x{394}"
      },
      {
        "to" => "d",
        "from" => "\x{3b4}"
      },
      {
        "to" => "E",
        "from" => "\x{395}"
      },
      {
        "to" => "e",
        "from" => "\x{3b5}"
      },
      {
        "to" => "E",
        "from" => "\x{388}"
      },
      {
        "to" => "e",
        "from" => "\x{3ad}"
      },
      {
        "to" => "Z",
        "from" => "\x{396}"
      },
      {
        "to" => "z",
        "from" => "\x{3b6}"
      },
      {
        "to" => "I",
        "from" => "\x{397}"
      },
      {
        "to" => "i",
        "from" => "\x{3b7}"
      },
      {
        "to" => "I",
        "from" => "\x{389}"
      },
      {
        "to" => "i",
        "from" => "\x{3ae}"
      },
      {
        "to" => "Th",
        "from" => "\x{398}"
      },
      {
        "to" => "th",
        "from" => "\x{3b8}"
      },
      {
        "to" => "I",
        "from" => "\x{399}"
      },
      {
        "to" => "i",
        "from" => "\x{3b9}"
      },
      {
        "to" => "I",
        "from" => "\x{38a}"
      },
      {
        "to" => "i",
        "from" => "\x{3af}"
      },
      {
        "to" => "I",
        "from" => "\x{3aa}"
      },
      {
        "to" => "i",
        "from" => "\x{3ca}"
      },
      {
        "to" => "i",
        "from" => "\x{390}"
      },
      {
        "to" => "K",
        "from" => "\x{39a}"
      },
      {
        "to" => "k",
        "from" => "\x{3ba}"
      },
      {
        "to" => "L",
        "from" => "\x{39b}"
      },
      {
        "to" => "l",
        "from" => "\x{3bb}"
      },
      {
        "to" => "M",
        "from" => "\x{39c}"
      },
      {
        "to" => "m",
        "from" => "\x{3bc}"
      },
      {
        "to" => "N",
        "from" => "\x{39d}"
      },
      {
        "to" => "n",
        "from" => "\x{3bd}"
      },
      {
        "to" => "X",
        "from" => "\x{39e}"
      },
      {
        "to" => "x",
        "from" => "\x{3be}"
      },
      {
        "to" => "O",
        "from" => "\x{39f}"
      },
      {
        "to" => "o",
        "from" => "\x{3bf}"
      },
      {
        "to" => "O",
        "from" => "\x{38c}"
      },
      {
        "to" => "o",
        "from" => "\x{3cc}"
      },
      {
        "to" => "P",
        "from" => "\x{3a0}"
      },
      {
        "to" => "p",
        "from" => "\x{3c0}"
      },
      {
        "to" => "R",
        "from" => "\x{3a1}"
      },
      {
        "to" => "r",
        "from" => "\x{3c1}"
      },
      {
        "to" => "S",
        "from" => "\x{3a3}"
      },
      {
        "to" => "s",
        "from" => "\x{3c3}"
      },
      {
        "to" => "T",
        "from" => "\x{3a4}"
      },
      {
        "to" => "t",
        "from" => "\x{3c4}"
      },
      {
        "to" => "I",
        "from" => "\x{3a5}"
      },
      {
        "to" => "i",
        "from" => "\x{3c5}"
      },
      {
        "to" => "I",
        "from" => "\x{38e}"
      },
      {
        "to" => "i",
        "from" => "\x{3cd}"
      },
      {
        "to" => "I",
        "from" => "\x{3ab}"
      },
      {
        "to" => "i",
        "from" => "\x{3cb}"
      },
      {
        "to" => "i",
        "from" => "\x{3b0}"
      },
      {
        "to" => "F",
        "from" => "\x{3a6}"
      },
      {
        "to" => "f",
        "from" => "\x{3c6}"
      },
      {
        "to" => "H",
        "from" => "\x{3a7}"
      },
      {
        "to" => "h",
        "from" => "\x{3c7}"
      },
      {
        "to" => "Ps",
        "from" => "\x{3a8}"
      },
      {
        "to" => "ps",
        "from" => "\x{3c8}"
      },
      {
        "to" => "O",
        "from" => "\x{3a9}"
      },
      {
        "to" => "o",
        "from" => "\x{3c9}"
      },
      {
        "to" => "O",
        "from" => "\x{38f}"
      },
      {
        "to" => "o",
        "from" => "\x{3ce}"
      },
      {
        "to" => "s",
        "from" => "\x{3c2}"
      },
      {
        "to" => "?",
        "from" => "\x{37e}",
        "context" => {
          "after" => "\\b"
        }
      },
      {
        "to" => "?",
        "from" => ";",
        "context" => {
          "after" => "\\b"
        }
      },
      {
        "to" => ";",
        "from" => "\x{b7}"
      },
      {
        "to" => "-",
        "from" => "\x{203f}"
      },
      {
        "to" => "",
        "from" => "\x{384}"
      },
      {
        "to" => "",
        "from" => "\x{385}"
      },
      {
        "to" => "",
        "from" => "\x{342}"
      },
      {
        "to" => "",
        "from" => "\x{343}"
      },
      {
        "to" => "",
        "from" => "\x{313}"
      },
      {
        "to" => "",
        "from" => "\x{314}"
      },
      {
        "to" => "",
        "from" => "\x{345}"
      },
      {
        "to" => "",
        "from" => "\x{345}"
      }
    ],
    "reverse" => "false"
  },
  "gost_7.79_ukr" => {
    "desc" => "GOST 7.79:2000, Cyrillic to Latin, Ukrainian",
    "name" => "GOST 7.79 UKR",
    "id" => "gost_7.79_ukr",
    "rules" => [
      {
        "to" => "c",
        "from" => "\x{446}",
        "context" => {
          "before" => "[iejy\x{438}\x{435}\x{439}\x{44e}\x{44f}\x{454}\x{456}\x{457}]"
        }
      },
      {
        "to" => "C",
        "from" => "\x{426}",
        "context" => {
          "before" => "[IEJY\x{418}\x{415}\x{419}\x{42e}\x{42f}\x{404}\x{406}\x{407}]"
        }
      },
      {
        "to" => "cz",
        "from" => "\x{446}"
      },
      {
        "to" => "CZ",
        "from" => "\x{426}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Cz",
        "from" => "\x{426}"
      },
      {
        "to" => "shh",
        "from" => "\x{449}"
      },
      {
        "to" => "SHH",
        "from" => "\x{429}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Shh",
        "from" => "\x{429}"
      },
      {
        "to" => "g`",
        "from" => "\x{491}"
      },
      {
        "to" => "G`",
        "from" => "\x{490}"
      },
      {
        "to" => "ye",
        "from" => "\x{454}"
      },
      {
        "to" => "YE",
        "from" => "\x{404}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ye",
        "from" => "\x{404}"
      },
      {
        "to" => "zh",
        "from" => "\x{436}"
      },
      {
        "to" => "ZH",
        "from" => "\x{416}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Zh",
        "from" => "\x{416}"
      },
      {
        "to" => "y`",
        "from" => "\x{438}"
      },
      {
        "to" => "Y`",
        "from" => "\x{418}"
      },
      {
        "to" => "yi",
        "from" => "\x{457}"
      },
      {
        "to" => "YI",
        "from" => "\x{407}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Yi",
        "from" => "\x{407}"
      },
      {
        "to" => "ch",
        "from" => "\x{447}"
      },
      {
        "to" => "CH",
        "from" => "\x{427}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ch",
        "from" => "\x{427}"
      },
      {
        "to" => "sh",
        "from" => "\x{448}"
      },
      {
        "to" => "SH",
        "from" => "\x{428}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Sh",
        "from" => "\x{428}"
      },
      {
        "to" => "yu",
        "from" => "\x{44e}"
      },
      {
        "to" => "YU",
        "from" => "\x{42e}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Yu",
        "from" => "\x{42e}"
      },
      {
        "to" => "ya",
        "from" => "\x{44f}"
      },
      {
        "to" => "YA",
        "from" => "\x{42f}",
        "context" => {
          "after" => "[\\p{IsUpper}\\p{IsSpace}]",
          "before" => "[\\p{IsUpper}\\p{IsSpace}]"
        }
      },
      {
        "to" => "Ya",
        "from" => "\x{42f}"
      },
      {
        "to" => "a",
        "from" => "\x{430}"
      },
      {
        "to" => "A",
        "from" => "\x{410}"
      },
      {
        "to" => "b",
        "from" => "\x{431}"
      },
      {
        "to" => "B",
        "from" => "\x{411}"
      },
      {
        "to" => "v",
        "from" => "\x{432}"
      },
      {
        "to" => "V",
        "from" => "\x{412}"
      },
      {
        "to" => "g",
        "from" => "\x{433}"
      },
      {
        "to" => "G",
        "from" => "\x{413}"
      },
      {
        "to" => "d",
        "from" => "\x{434}"
      },
      {
        "to" => "D",
        "from" => "\x{414}"
      },
      {
        "to" => "e",
        "from" => "\x{435}"
      },
      {
        "to" => "E",
        "from" => "\x{415}"
      },
      {
        "to" => "z",
        "from" => "\x{437}"
      },
      {
        "to" => "Z",
        "from" => "\x{417}"
      },
      {
        "to" => "j",
        "from" => "\x{439}"
      },
      {
        "to" => "J",
        "from" => "\x{419}"
      },
      {
        "to" => "i",
        "from" => "\x{456}"
      },
      {
        "to" => "I",
        "from" => "\x{406}"
      },
      {
        "to" => "k",
        "from" => "\x{43a}"
      },
      {
        "to" => "K",
        "from" => "\x{41a}"
      },
      {
        "to" => "l",
        "from" => "\x{43b}"
      },
      {
        "to" => "L",
        "from" => "\x{41b}"
      },
      {
        "to" => "m",
        "from" => "\x{43c}"
      },
      {
        "to" => "M",
        "from" => "\x{41c}"
      },
      {
        "to" => "n",
        "from" => "\x{43d}"
      },
      {
        "to" => "N",
        "from" => "\x{41d}"
      },
      {
        "to" => "o",
        "from" => "\x{43e}"
      },
      {
        "to" => "O",
        "from" => "\x{41e}"
      },
      {
        "to" => "p",
        "from" => "\x{43f}"
      },
      {
        "to" => "P",
        "from" => "\x{41f}"
      },
      {
        "to" => "r",
        "from" => "\x{440}"
      },
      {
        "to" => "R",
        "from" => "\x{420}"
      },
      {
        "to" => "s",
        "from" => "\x{441}"
      },
      {
        "to" => "S",
        "from" => "\x{421}"
      },
      {
        "to" => "t",
        "from" => "\x{442}"
      },
      {
        "to" => "T",
        "from" => "\x{422}"
      },
      {
        "to" => "u",
        "from" => "\x{443}"
      },
      {
        "to" => "U",
        "from" => "\x{423}"
      },
      {
        "to" => "f",
        "from" => "\x{444}"
      },
      {
        "to" => "F",
        "from" => "\x{424}"
      },
      {
        "to" => "x",
        "from" => "\x{445}"
      },
      {
        "to" => "X",
        "from" => "\x{425}"
      },
      {
        "to" => "`",
        "from" => "\x{42c}",
        "context" => {
          "after" => "\\p{IsUpper}"
        }
      },
      {
        "to" => "`",
        "from" => "\x{44c}"
      },
      {
        "to" => "#",
        "from" => "\x{2116}"
      }
    ],
    "reverse" => "true"
  }
);
?>