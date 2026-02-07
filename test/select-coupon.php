                  <?php
                // Fetch discount coupons based on user_type
                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
                    $sql = $dbh1->prepare("
                        SELECT deal_code2, offer_text
                        FROM reservation_discount
                        WHERE deal_code2 != '' AND active = 1 AND level = 1
                    ");
                } else {
                    $sql = $dbh1->prepare("
                        SELECT deal_code2, offer_text
                        FROM reservation_discount
                        WHERE deal_code2 != '' AND active = 1 AND level IN (1, 2)
                    ");
                }
                $sql->execute();
                $result = $sql->get_result();
                $discountCoupons = $result->fetch_all(MYSQLI_ASSOC);

                // Get saved discount code from reservation if editing
                $selectedDiscount = '';
                if (isset($_REQUEST['res_id']) && $_REQUEST['res_id'] != "") {
                    $sql = $dbh1->prepare("SELECT lp_dealcode FROM reservation WHERE id=?");
                    $sql->bind_param("i", $_REQUEST['res_id']);
                    $sql->execute();
                    $result = $sql->get_result();
                    $row1 = $result->fetch_assoc();

                    if (!empty($row1['lp_dealcode'])) {
                        $codes = explode(',', $row1['lp_dealcode']);
                        // If there’s a second code, use it as discount
                        if (isset($codes[1])) {
                            $selectedDiscount = $codes[1];
                        }
                    }
                }
                ?>