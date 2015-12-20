          <?php
                    error_reporting(0);
                    
                    function saveImages($array, $directory, $success){
                        $image = array_pop($array);

                        $url = $image;
                        $file_name = explode('/', $url);
                        $count = count($file_name);
                        $img = $file_name[--$count];
                        $img_format = explode('.', $img);
                        $img_format = array_pop($img_format);

                        if(count($array) == 0){
                                print_r(json_encode($success));
                        }

                        if ( $img_format === 'gif' || $img_format === 'jpg' || $img_format === 'png'){

                            $destination = $directory.'/'.$img;
                            $saved = array_push($success,  $destination);
                            if ( file_put_contents($destination, file_get_contents($url) ) && count($array) >= 1 ){                         
                                saveImages($array, $directory, $success);
                            }
                            
                        }
                        else {
                            if ( count($array) >= 1 ){
                                saveImages($array, $directory, $success);

                            }
                        }
                    }

            if( isset($_POST['url']) ){

                $url = $_POST['url'];

                // CHEKICNG IF URL IS CORRECT
                if ( preg_match('~(https://|http://)~', $url) ){

                    // GETTING DOMAIN NAME
                    $url_parts = explode('/', $url);
                    $domain = implode('/', [$url_parts[0] ,$url_parts[1] ,$url_parts[2]]);
                    $directory = '../extracted_images/'.$url_parts[2];

                    // CREATE NEW DOMDOCUMENT OBJECT THAT STORE OUR PAGE
                    libxml_use_internal_errors(true);
                    $page = new DOMDocument();
                    $page->loadHTMLFile($url);
                    $page->saveHTMLFile('file.html');
                    $elements = $page->getElementsByTagName('img');

                    // ARRAY WITH ALL IMAGE LINKS
                    $links = [];
                    $success = [];
                    foreach ( $elements as $element ) {

                        $src = $element->getAttribute('src');

                        // PUSH LINK INTO ARRAY
                        if ( preg_match( '~(https://|http://)~', $src )){
                            array_push($links, $src);
                        }
                        else {
                            $src = $domain.$src;
                            array_push($links, $src);
                        }

                    }

                    if (is_dir($directory) === false){

                        if (mkdir($directory, 0700)){
                            $new_directory = $directory;
                        }
                        else {
                            
                        }

                    }


                    saveImages($links, $directory, $success);
                }
                else{
                    echo 'Insert correct value: "It must start from http:// or https://"';
                }

            }

            ?>