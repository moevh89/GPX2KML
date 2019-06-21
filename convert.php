<?php

//Copyright (C) 2019 Yunus Kahveci
//Have a look at the README.md and LICENSE files!

error_reporting(0);

try {

    $files = glob('tmp/*'); // get all file names
    foreach($files as $file){ // iterate files
        if(is_file($file))
            unlink($file); // delete file
    }

    if ($_FILES['file']['name'] <> "") {


        $id = md5(base64_encode($_FILES['file']['tmp_name'] . time()));

        $fileName = "$id.gpx";
        if (file_exists("tmp/$fileName")) {
            unlink("tmp/$fileName");
        }


        move_uploaded_file($_FILES['file']['tmp_name'], 'tmp/' . $fileName);

        $data = file_get_contents('tmp/' . $fileName);


        $p = xml_parser_create();
        xml_parse_into_struct($p, $data, $values, $index);
        xml_parser_free($p);

        $content = '<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2"  xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2"    
     xmlns:atom="http://www.w3.org/2005/Atom">
    <Document>
        <name><![CDATA[iOverlander Places - Mauritius - 2019-06-20]]></name>
        
                                <atom:link href="http://iOverlander.com"/>
            
                            <TimeStamp>
                <when>2019-06-20T14:25:28-04:00</when>
            </TimeStamp> 
            
                
        <description><![CDATA[<br/><p> </p><p><br/>Converted using <b><a href=\'http://gpx2kml.com\' title=\'Go to gpx2kml.com\'>gpx2kml.com</a></b></p><br/>]]></description>
        <visibility>1</visibility>
        <open>1</open>
        
                <Style id="red">
            <LineStyle>
            <color>C81400FF</color>
            <width>4</width>
            </LineStyle>
        </Style>
        <Style id="route_red">
            <LineStyle>
            <color>961400FF</color>
            <width>4</width>
            </LineStyle>
        </Style>
                <Style id="green">
            <LineStyle>
            <color>C878FF00</color>
            <width>4</width>
            </LineStyle>
        </Style>
        <Style id="route_green">
            <LineStyle>
            <color>9678FF00</color>
            <width>4</width>
            </LineStyle>
        </Style>
                <Style id="blue">
            <LineStyle>
            <color>C8FF7800</color>
            <width>4</width>
            </LineStyle>
        </Style>
        <Style id="route_blue">
            <LineStyle>
            <color>96FF7800</color>
            <width>4</width>
            </LineStyle>
        </Style>
                <Style id="cyan">
            <LineStyle>
            <color>C8F0FF14</color>
            <width>4</width>
            </LineStyle>
        </Style>
        <Style id="route_cyan">
            <LineStyle>
            <color>96F0FF14</color>
            <width>4</width>
            </LineStyle>
        </Style>
                <Style id="orange">
            <LineStyle>
            <color>C81478FF</color>
            <width>4</width>
            </LineStyle>
        </Style>
        <Style id="route_orange">
            <LineStyle>
            <color>961478FF</color>
            <width>4</width>
            </LineStyle>
        </Style>
                <Style id="dark_green">
            <LineStyle>
            <color>C8008C14</color>
            <width>4</width>
            </LineStyle>
        </Style>
        <Style id="route_dark_green">
            <LineStyle>
            <color>96008C14</color>
            <width>4</width>
            </LineStyle>
        </Style>
                <Style id="purple">
            <LineStyle>
            <color>C8FF7878</color>
            <width>4</width>
            </LineStyle>
        </Style>
        <Style id="route_purple">
            <LineStyle>
            <color>96FF7878</color>
            <width>4</width>
            </LineStyle>
        </Style>
                <Style id="pink">
            <LineStyle>
            <color>C8A078F0</color>
            <width>4</width>
            </LineStyle>
        </Style>
        <Style id="route_pink">
            <LineStyle>
            <color>96A078F0</color>
            <width>4</width>
            </LineStyle>
        </Style>
                <Style id="brown">
            <LineStyle>
            <color>C8143C96</color>
            <width>4</width>
            </LineStyle>
        </Style>
        <Style id="route_brown">
            <LineStyle>
            <color>96143C96</color>
            <width>4</width>
            </LineStyle>
        </Style>
                <Style id="dark_blue">
            <LineStyle>
            <color>C8F01414</color>
            <width>4</width>
            </LineStyle>
        </Style>
        <Style id="route_dark_blue">
            <LineStyle>
            <color>96F01414</color>
            <width>4</width>
            </LineStyle>
        </Style>
        
                
        <Folder>
            <name>Waypoints</name>
            <description>A list of waypoints</description>
            <visibility>1</visibility>
            <open>0</open>
                                                                                
            
            ';

        foreach ($index['WPT'] as $WPTId) {
            if ($values[$WPTId]['type'] === "open" && $values[$WPTId]['level'] === 2) {
                $convert = true;
                $forSearchIndex = $WPTId + 1;
                for ($forSearchInterrupt = false; !$forSearchInterrupt; $forSearchIndex++) {
                    if ($values[$forSearchIndex]['tag'] === "NAME" && $values[$forSearchIndex]['type'] === "complete") {
                        $name = $values[$forSearchIndex]['value'];
                    } elseif ($values[$forSearchIndex]['tag'] === "ELE" && $values[$forSearchIndex]['type'] === "complete") {
                        $ele = $values[$forSearchIndex]['value'];
                    } elseif ($values[$forSearchIndex]['tag'] === "DESC" && $values[$forSearchIndex]['type'] === "complete") {
                        $desc = $values[$forSearchIndex]['value'];
                    } elseif ($values[$forSearchIndex]['tag'] === "LINK" && $values[$forSearchIndex]['type'] === "open") {
                        $link = $values[$forSearchIndex]['attributes']['HREF'];
                    } elseif ($values[$forSearchIndex]['tag'] === "TYPE" && $values[$forSearchIndex]['type'] === "complete") {
                        $type = $values[$forSearchIndex]['value'];
                    } elseif ($values[$forSearchIndex]['tag'] === "ELE" && $values[$forSearchIndex]['type'] === "complete") {
                        $ele = $values[$forSearchIndex]['value'];
                    } elseif ($values[$forSearchIndex]['type'] === "close" && $values[$forSearchIndex]['tag'] === "WPT") {
                        $forSearchInterrupt = true;

                    }
                }

                if ($type == "iOverlander Established Campground" || $type == "iOverlander Informal Campsite" || $type == "iOverlander Wild Camping") {
                    $color = "<styleUrl>#placemark-green</styleUrl>";
                } elseif ($type == "iOverlander Hotel" || $type == "iOverlander Hostel") {
                    $color = "<styleUrl>#placemark-blue</styleUrl>";
                } elseif ($type == "iOverlander Fuel Station" || $type == "iOverlander Propane" || $type == "iOverlander Mechanic and Parts" || $type == "iOverlander Water") {
                    $color = "<styleUrl>#placemark-purple</styleUrl>";
                } elseif ($type == "iOverlander Sanitation Dump Station") {
                    $color = "<styleUrl>#placemark-brown</styleUrl>";
                } elseif ($type == "iOverlander Restaurant" || $type == "iOverlander Tourist Attraction" || $type == "iOverlander Shopping" || $type == "iOverlander Medical" || $type == "iOverlander Pet Services" || $type == "iOverlander Laudromat") {
                    $color = "<styleUrl>#placemark-yellow</styleUrl>";
                } elseif ($type == "iOverlander Customs and Immigration" || $type == "iOverlander Checkpoint" || $type == "iOverlander Consulate / Embassy") {
                    $color = "<styleUrl>#placemark-red</styleUrl>";
                } elseif ($type == "iOverlander Vehicle Insurance" || $type == "iOverlander Vehicle Storage" || $type == "iOverlander Vehicle Shipping") {
                    $color = "<styleUrl>#placemark-orange</styleUrl>";
                } elseif ($type == "iOverlander Warning" || $type == "iOverlander Other") {
                    $color = "<styleUrl>#placemark-pink</styleUrl>";
                } else {
                    $color = "";
                }

                $chosenCategory = false;
                $type = str_replace("iOverlander ", "", $type);
                foreach ($_POST['categories'] as $category) {
                    if($category == $type) {
                        $chosenCategory = true;
                    }
                }



                if($chosenCategory) {


                    $content = $content . '<Placemark>
                <name>' . $name . '</name>                      
                <visibility>1</visibility>            
                <open>0</open>                        
                                
                <atom:link href="' . $link . '"/>
                                                
                <description>
                - ' . $desc . '  </description>       
                <LookAt>
                    <longitude>' . $values[$WPTId]['attributes']['LON'] . '</longitude>
                    <latitude>' . $values[$WPTId]['attributes']['LAT'] . '</latitude>
                    <range>500</range>
                    <tilt>45</tilt>
                    <heading>0</heading>
                </LookAt>
                <Point>
                    <coordinates>
                        ' . $values[$WPTId]['attributes']['LON'] . "," . $values[$WPTId]['attributes']['LAT'] . ',' . $ele . '                        
                    </coordinates>
                </Point>
            </Placemark>
            
            ';

                }
            }

        }

        $content = $content . '

        </Folder>
         


        <LookAt>
            <longitude>57.51671</longitude>            
            <latitude>-20.24971</latitude>             
            <altitude>0</altitude>               
            <heading>0</heading>               
            <tilt>45</tilt>
            <range>5456</range>                    
            <altitudeMode>clampToGround</altitudeMode> 
        </LookAt>
    </Document>
</kml>';

        $convertedFileName = "tmp/" . str_replace(".gpx", "", $_FILES['file']['name']) . " - " . $id . ".kml";
        if ($convert) {
            $handle = fopen($convertedFileName, "w");
            fwrite($handle, $content);
            fclose($handle);

            header("Location: $convertedFileName");
        } else {
            echo("No waypoints were found. Try another file.");
            $noWayPoints = true;
        }
    } else {
        header("Location: index.php");
        die();
    }
} finally {
    if (!$noWayPoints) {
        echo("An error occurred. Please try again later.");
    }
}