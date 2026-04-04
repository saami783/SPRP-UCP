CREATE TABLE `ucp_applications` (
  `ucp_application_id` int(11) NOT NULL,
  `ucp_date` varchar(24) NOT NULL DEFAULT 'NaN',
  `ucp_account_id` int(11) NOT NULL DEFAULT 0,
  `ucp_account_name` varchar(24) NOT NULL,
  `ucp_account_email` varchar(96) DEFAULT NULL,
  `ucp_question_1` text NOT NULL,
  `ucp_question_2` text NOT NULL,
  `ucp_question_3` text NOT NULL,
  `ucp_question_4` text NOT NULL,
  `ucp_question_5` text NOT NULL,
  `ucp_question_6` text NOT NULL,
  `ucp_app_status` tinyint(4) NOT NULL DEFAULT 0,
  `ucp_ip_address` varchar(32) NOT NULL,
  `ucp_handled_by` varchar(24) DEFAULT 'NaN',
  `ucp_handled_note` text NOT NULL,
  `ucp_handled_date` bigint(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ucp_requests`
--

CREATE TABLE `ucp_requests` (
  `ucp_request_id` int(11) NOT NULL,
  `ucp_request_name` varchar(24) NOT NULL,
  `ucp_request_ip` varchar(32) NOT NULL,
  `ucp_request_timestamp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_sqlid` int(11) NOT NULL,
  `vehicle_modelid` smallint(6) NOT NULL DEFAULT 462,
  `vehicle_type` tinyint(4) NOT NULL DEFAULT 0,
  `vehicle_jobid` tinyint(4) NOT NULL DEFAULT 0,
  `vehicle_siren` tinyint(4) NOT NULL DEFAULT 0,
  `vehicle_owner` int(11) NOT NULL DEFAULT -1,
  `vehicle_mileage` int(11) NOT NULL DEFAULT 0,
  `vehicle_color_a` smallint(6) NOT NULL DEFAULT -1,
  `vehicle_color_b` smallint(6) NOT NULL DEFAULT -1,
  `vehicle_pos_x` float NOT NULL,
  `vehicle_pos_y` float NOT NULL,
  `vehicle_pos_z` float NOT NULL,
  `vehicle_pos_a` float NOT NULL,
  `vehicle_license` varchar(16) NOT NULL DEFAULT 'LS-0000',
  `vehicle_fuel` tinyint(4) NOT NULL DEFAULT 25,
  `vehicle_neon` tinyint(4) NOT NULL DEFAULT 0,
  `vehicle_trunk_wep_1` tinyint(4) NOT NULL DEFAULT 0,
  `vehicle_trunk_ammo_1` smallint(6) NOT NULL DEFAULT 0,
  `vehicle_trunk_wep_2` tinyint(4) NOT NULL DEFAULT 0,
  `vehicle_trunk_ammo_2` smallint(6) NOT NULL DEFAULT 0,
  `vehicle_trunk_wep_3` tinyint(4) NOT NULL DEFAULT 0,
  `vehicle_trunk_ammo_3` smallint(6) NOT NULL DEFAULT 0,
  `vehicle_trunk_wep_4` tinyint(4) NOT NULL DEFAULT 0,
  `vehicle_trunk_ammo_4` smallint(6) NOT NULL DEFAULT 0,
  `vehicle_trunk_wep_5` tinyint(4) NOT NULL DEFAULT 0,
  `vehicle_trunk_ammo_5` smallint(6) NOT NULL DEFAULT 0,
  `vehicle_paintjob` tinyint(4) NOT NULL DEFAULT 3,
  `vehicle_health` float NOT NULL DEFAULT 1000,
  `vehicle_dmg_panels` int(11) NOT NULL DEFAULT 0,
  `vehicle_dmg_doors` int(11) NOT NULL DEFAULT 0,
  `vehicle_dmg_lights` int(11) NOT NULL DEFAULT 0,
  `vehicle_dmg_tires` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_wep_6` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_ammo_6` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_wep_7` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_ammo_7` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_wep_8` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_ammo_8` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_wep_9` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_ammo_9` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_wep_10` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_ammo_10` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_type_1` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_param_1` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_cont_1` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_amount_1` float NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_type_2` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_param_2` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_cont_2` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_amount_2` float NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_type_3` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_param_3` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_cont_3` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_amount_3` float NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_type_4` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_param_4` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_cont_4` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_amount_4` float NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_type_5` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_param_5` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_cont_5` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_amount_5` float NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_type_6` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_param_6` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_cont_6` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_amount_6` float NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_type_7` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_param_7` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_cont_7` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_amount_7` float NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_type_8` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_param_8` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_cont_8` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_amount_8` float NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_type_9` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_param_9` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_cont_9` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_amount_9` float NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_type_10` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_param_10` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_cont_10` int(11) NOT NULL DEFAULT 0,
  `vehicle_trunk_drugs_amount_10` float NOT NULL DEFAULT 0,
  `vehicle_doors` int(11) NOT NULL DEFAULT 0,
  `vehicle_parked_at` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `vehicle_impounded` int(11) NOT NULL DEFAULT 0,
  `vehicle_impounded_until` datetime DEFAULT NULL,
  `vehicle_impound_cost` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `vehicle_impound_reason` varchar(255) DEFAULT NULL,
  `vehicle_impounded_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_components`
--

CREATE TABLE `vehicle_components` (
  `componentid` smallint(4) UNSIGNED NOT NULL,
  `part` enum('Exhausts','Front Bullbars','Front Bumper','Hood','Hydraulics','Lights','Misc','Rear Bullbars','Rear Bumper','Roof','Side Skirts','Spoilers','Vents','Wheels') DEFAULT NULL,
  `type` varchar(22) NOT NULL,
  `cars` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_model_parts`
--

CREATE TABLE `vehicle_model_parts` (
  `modelid` smallint(3) UNSIGNED NOT NULL,
  `parts` bit(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_saved_mods`
--

CREATE TABLE `vehicle_saved_mods` (
  `vehicle_saved_id` int(11) NOT NULL,
  `vehicle_sql_id` int(11) NOT NULL,
  `vehicle_component_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_trunks`
--

CREATE TABLE `vehicle_trunks` (
  `trunk_sql_id` int(11) NOT NULL,
  `trunk_veh_sql_id` int(11) NOT NULL,
  `trunk_weapon_1` tinyint(11) NOT NULL,
  `trunk_weapon_ammo_1` int(11) NOT NULL,
  `trunk_weapon_2` tinyint(11) NOT NULL,
  `trunk_weapon_ammo_2` int(11) NOT NULL,
  `trunk_weapon_3` tinyint(11) NOT NULL,
  `trunk_weapon_ammo_3` int(11) NOT NULL,
  `trunk_weapon_4` tinyint(11) NOT NULL,
  `trunk_weapon_ammo_4` int(11) NOT NULL,
  `trunk_weapon_5` tinyint(11) NOT NULL,
  `trunk_weapon_ammo_5` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wardrobes`
--

CREATE TABLE `wardrobes` (
  `wardrobe_id` int(10) UNSIGNED NOT NULL,
  `wardrobe_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `wardrobe_owner` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `wardrobe_name` varchar(255) DEFAULT 'Wardrobe',
  `wardrobe_pos_x` float NOT NULL,
  `wardrobe_pos_y` float NOT NULL,
  `wardrobe_pos_z` float NOT NULL,
  `wardrobe_pos_a` float NOT NULL DEFAULT 0,
  `wardrobe_world` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `wardrobe_int` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weapons`
--

CREATE TABLE `weapons` (
  `character_id` int(11) NOT NULL,
  `weapon_id` tinyint(16) NOT NULL,
  `weapon_ammo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `admin_notes`
--
ALTER TABLE `admin_notes`
  ADD PRIMARY KEY (`note_id`);

--
-- Indexes for table `admin_record`
--
ALTER TABLE `admin_record`
  ADD PRIMARY KEY (`record_id`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`attach_sqlid`);

--
-- Indexes for table `attachpoint`
--
ALTER TABLE `attachpoint`
  ADD PRIMARY KEY (`attach_point_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`bank_sqlid`);

--
-- Indexes for table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`ban_id`);

--
-- Indexes for table `buyable_skins`
--
ALTER TABLE `buyable_skins`
  ADD PRIMARY KEY (`buyable_skin_id`);

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`player_id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`contract_sqlid`);

--
-- Indexes for table `criminalfines`
--
ALTER TABLE `criminalfines`
  ADD PRIMARY KEY (`fine_id`);

--
-- Indexes for table `criminalrecords`
--
ALTER TABLE `criminalrecords`
  ADD PRIMARY KEY (`record_id`);

--
-- Indexes for table `drugplants`
--
ALTER TABLE `drugplants`
  ADD PRIMARY KEY (`drug_plant_id`),
  ADD UNIQUE KEY `drug_plant_id` (`drug_plant_id`);

--
-- Indexes for table `drugs_player_owned`
--
ALTER TABLE `drugs_player_owned`
  ADD PRIMARY KEY (`player_drug_sqlid`);

--
-- Indexes for table `drugs_player_packages`
--
ALTER TABLE `drugs_player_packages`
  ADD PRIMARY KEY (`package_character_id`);

--
-- Indexes for table `drugs_player_stations`
--
ALTER TABLE `drugs_player_stations`
  ADD PRIMARY KEY (`drug_sqlid`);

--
-- Indexes for table `drugs_player_supplies`
--
ALTER TABLE `drugs_player_supplies`
  ADD UNIQUE KEY `drug_supply_characterid` (`drug_supply_characterid`);

--
-- Indexes for table `emmet`
--
ALTER TABLE `emmet`
  ADD PRIMARY KEY (`emmet_sqlid`) USING BTREE;

--
-- Indexes for table `emmet_factions`
--
ALTER TABLE `emmet_factions`
  ADD PRIMARY KEY (`emmet_faction_sqlid`);

--
-- Indexes for table `emmet_player`
--
ALTER TABLE `emmet_player`
  ADD PRIMARY KEY (`emmet_player_account_id`),
  ADD UNIQUE KEY `unique_emmet_player_account_id` (`emmet_player_account_id`);

--
-- Indexes for table `enex_buypoint`
--
ALTER TABLE `enex_buypoint`
  ADD PRIMARY KEY (`enex_buypoint_sqlid`),
  ADD UNIQUE KEY `enex_buypoint_sqlid_2` (`enex_buypoint_sqlid`),
  ADD KEY `enex_buypoint_sqlid` (`enex_buypoint_sqlid`),
  ADD KEY `enex_buypoint_sqlid_3` (`enex_buypoint_sqlid`);

--
-- Indexes for table `enex_master`
--
ALTER TABLE `enex_master`
  ADD PRIMARY KEY (`enex_sqlid`);

--
-- Indexes for table `event_christmas`
--
ALTER TABLE `event_christmas`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `account_id` (`account_id`);

--
-- Indexes for table `event_easter_eggs`
--
ALTER TABLE `event_easter_eggs`
  ADD PRIMARY KEY (`found_id`);

--
-- Indexes for table `event_halloween`
--
ALTER TABLE `event_halloween`
  ADD PRIMARY KEY (`found_id`);

--
-- Indexes for table `factions`
--
ALTER TABLE `factions`
  ADD PRIMARY KEY (`faction_id`);

--
-- Indexes for table `faction_skins`
--
ALTER TABLE `faction_skins`
  ADD PRIMARY KEY (`faction_skin_id`);

--
-- Indexes for table `faction_skins_dev`
--
ALTER TABLE `faction_skins_dev`
  ADD PRIMARY KEY (`faction_skin_id`);

--
-- Indexes for table `firms`
--
ALTER TABLE `firms`
  ADD PRIMARY KEY (`firm_sqlid`);

--
-- Indexes for table `fuelmanager`
--
ALTER TABLE `fuelmanager`
  ADD PRIMARY KEY (`fuelmanager_id`);

--
-- Indexes for table `fuelstation`
--
ALTER TABLE `fuelstation`
  ADD PRIMARY KEY (`fuelstation_id`);

--
-- Indexes for table `furniture`
--
ALTER TABLE `furniture`
  ADD PRIMARY KEY (`furniture_sqlid`);

--
-- Indexes for table `gangzones`
--
ALTER TABLE `gangzones`
  ADD PRIMARY KEY (`gz_sqlid`);

--
-- Indexes for table `gates`
--
ALTER TABLE `gates`
  ADD PRIMARY KEY (`gate_sqlid`);

--
-- Indexes for table `gd_factory`
--
ALTER TABLE `gd_factory`
  ADD PRIMARY KEY (`factory`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_data_sqlid`);

--
-- Indexes for table `gym`
--
ALTER TABLE `gym`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `kiosks`
--
ALTER TABLE `kiosks`
  ADD PRIMARY KEY (`kiosk_id`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`license_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modshops`
--
ALTER TABLE `modshops`
  ADD PRIMARY KEY (`mod_shop_id`);

--
-- Indexes for table `passpoints`
--
ALTER TABLE `passpoints`
  ADD PRIMARY KEY (`passpoint_sqlid`);

--
-- Indexes for table `payphones`
--
ALTER TABLE `payphones`
  ADD PRIMARY KEY (`payphone_sqlid`);

--
-- Indexes for table `phonebook`
--
ALTER TABLE `phonebook`
  ADD PRIMARY KEY (`phonebook_id`);

--
-- Indexes for table `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`phone_number_id`),
  ADD UNIQUE KEY `phone_number_digits` (`phone_number_digits`);

--
-- Indexes for table `phone_contacts`
--
ALTER TABLE `phone_contacts`
  ADD PRIMARY KEY (`phone_contact_sqlid`);

--
-- Indexes for table `phone_logs`
--
ALTER TABLE `phone_logs`
  ADD PRIMARY KEY (`phone_log_sqlid`);

--
-- Indexes for table `player_attachments`
--
ALTER TABLE `player_attachments`
  ADD PRIMARY KEY (`player_attach_sqlid`);

--
-- Indexes for table `player_drugs`
--
ALTER TABLE `player_drugs`
  ADD PRIMARY KEY (`drug_sqlid`);

--
-- Indexes for table `player_logs`
--
ALTER TABLE `player_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `log_type` (`log_type`),
  ADD KEY `log_char_id` (`log_char_id`),
  ADD KEY `log_id` (`log_id`),
  ADD KEY `log_time` (`log_time`);

--
-- Indexes for table `player_props`
--
ALTER TABLE `player_props`
  ADD UNIQUE KEY `prop_index` (`prop_index`);

--
-- Indexes for table `player_skins`
--
ALTER TABLE `player_skins`
  ADD PRIMARY KEY (`player_skin_id`),
  ADD KEY `player_skin_charid` (`player_skin_charid`);

--
-- Indexes for table `player_wardrobes`
--
ALTER TABLE `player_wardrobes`
  ADD PRIMARY KEY (`player_wardrobe_char_id`,`player_wardrobe_skin_id`);

--
-- Indexes for table `player_weapons`
--
ALTER TABLE `player_weapons`
  ADD UNIQUE KEY `character_id` (`character_id`,`weapon_id`);

--
-- Indexes for table `player_weapons_attach`
--
ALTER TABLE `player_weapons_attach`
  ADD PRIMARY KEY (`SQLID`);

--
-- Indexes for table `poker`
--
ALTER TABLE `poker`
  ADD PRIMARY KEY (`poker_table_id`);

--
-- Indexes for table `pool`
--
ALTER TABLE `pool`
  ADD PRIMARY KEY (`pool_sqlid`),
  ADD UNIQUE KEY `pool_sqlid` (`pool_sqlid`),
  ADD KEY `pool_sqlid_2` (`pool_sqlid`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_id`);

--
-- Indexes for table `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`refund_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registration_id`),
  ADD UNIQUE KEY `account_id` (`account_id`);

--
-- Indexes for table `report_activity`
--
ALTER TABLE `report_activity`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `server`
--
ALTER TABLE `server`
  ADD PRIMARY KEY (`server_index`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`e_session_id`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`sms_id`);

--
-- Indexes for table `sols_passpoints`
--
ALTER TABLE `sols_passpoints`
  ADD PRIMARY KEY (`passpoint_sqlid`);

--
-- Indexes for table `spraytags`
--
ALTER TABLE `spraytags`
  ADD PRIMARY KEY (`spraytag_sqlid`);

--
-- Indexes for table `strawman_logs`
--
ALTER TABLE `strawman_logs`
  ADD PRIMARY KEY (`strawman_log_id`);

--
-- Indexes for table `ucp_applications`
--
ALTER TABLE `ucp_applications`
  ADD PRIMARY KEY (`ucp_application_id`);

--
-- Indexes for table `ucp_requests`
--
ALTER TABLE `ucp_requests`
  ADD PRIMARY KEY (`ucp_request_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_sqlid`);

--
-- Indexes for table `vehicle_components`
--
ALTER TABLE `vehicle_components`
  ADD PRIMARY KEY (`componentid`),
  ADD KEY `cars` (`cars`),
  ADD KEY `part` (`part`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `vehicle_model_parts`
--
ALTER TABLE `vehicle_model_parts`
  ADD PRIMARY KEY (`modelid`);

--
-- Indexes for table `vehicle_saved_mods`
--
ALTER TABLE `vehicle_saved_mods`
  ADD PRIMARY KEY (`vehicle_saved_id`);

--
-- Indexes for table `vehicle_trunks`
--
ALTER TABLE `vehicle_trunks`
  ADD PRIMARY KEY (`trunk_sql_id`);

--
-- Indexes for table `wardrobes`
--
ALTER TABLE `wardrobes`
  ADD PRIMARY KEY (`wardrobe_id`);

--
-- Indexes for table `weapons`
--
ALTER TABLE `weapons`
  ADD UNIQUE KEY `character_id` (`character_id`,`weapon_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_notes`
--
ALTER TABLE `admin_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_record`
--
ALTER TABLE `admin_record`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `attach_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachpoint`
--
ALTER TABLE `attachpoint`
  MODIFY `attach_point_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `bank_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `ban_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buyable_skins`
--
ALTER TABLE `buyable_skins`
  MODIFY `buyable_skin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `player_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `contract_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criminalfines`
--
ALTER TABLE `criminalfines`
  MODIFY `fine_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criminalrecords`
--
ALTER TABLE `criminalrecords`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drugplants`
--
ALTER TABLE `drugplants`
  MODIFY `drug_plant_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drugs_player_owned`
--
ALTER TABLE `drugs_player_owned`
  MODIFY `player_drug_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drugs_player_stations`
--
ALTER TABLE `drugs_player_stations`
  MODIFY `drug_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emmet`
--
ALTER TABLE `emmet`
  MODIFY `emmet_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emmet_factions`
--
ALTER TABLE `emmet_factions`
  MODIFY `emmet_faction_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enex_buypoint`
--
ALTER TABLE `enex_buypoint`
  MODIFY `enex_buypoint_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enex_master`
--
ALTER TABLE `enex_master`
  MODIFY `enex_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_easter_eggs`
--
ALTER TABLE `event_easter_eggs`
  MODIFY `found_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_halloween`
--
ALTER TABLE `event_halloween`
  MODIFY `found_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `factions`
--
ALTER TABLE `factions`
  MODIFY `faction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faction_skins`
--
ALTER TABLE `faction_skins`
  MODIFY `faction_skin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faction_skins_dev`
--
ALTER TABLE `faction_skins_dev`
  MODIFY `faction_skin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `firms`
--
ALTER TABLE `firms`
  MODIFY `firm_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fuelmanager`
--
ALTER TABLE `fuelmanager`
  MODIFY `fuelmanager_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fuelstation`
--
ALTER TABLE `fuelstation`
  MODIFY `fuelstation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `furniture`
--
ALTER TABLE `furniture`
  MODIFY `furniture_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gangzones`
--
ALTER TABLE `gangzones`
  MODIFY `gz_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gates`
--
ALTER TABLE `gates`
  MODIFY `gate_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_data_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gym`
--
ALTER TABLE `gym`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kiosks`
--
ALTER TABLE `kiosks`
  MODIFY `kiosk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `license_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modshops`
--
ALTER TABLE `modshops`
  MODIFY `mod_shop_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passpoints`
--
ALTER TABLE `passpoints`
  MODIFY `passpoint_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payphones`
--
ALTER TABLE `payphones`
  MODIFY `payphone_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phonebook`
--
ALTER TABLE `phonebook`
  MODIFY `phonebook_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `phone_number_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_contacts`
--
ALTER TABLE `phone_contacts`
  MODIFY `phone_contact_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_logs`
--
ALTER TABLE `phone_logs`
  MODIFY `phone_log_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player_attachments`
--
ALTER TABLE `player_attachments`
  MODIFY `player_attach_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player_drugs`
--
ALTER TABLE `player_drugs`
  MODIFY `drug_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player_logs`
--
ALTER TABLE `player_logs`
  MODIFY `log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player_props`
--
ALTER TABLE `player_props`
  MODIFY `prop_index` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player_skins`
--
ALTER TABLE `player_skins`
  MODIFY `player_skin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player_weapons_attach`
--
ALTER TABLE `player_weapons_attach`
  MODIFY `SQLID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poker`
--
ALTER TABLE `poker`
  MODIFY `poker_table_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pool`
--
ALTER TABLE `pool`
  MODIFY `pool_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `property_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refunds`
--
ALTER TABLE `refunds`
  MODIFY `refund_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_activity`
--
ALTER TABLE `report_activity`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `e_session_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `sms_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sols_passpoints`
--
ALTER TABLE `sols_passpoints`
  MODIFY `passpoint_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spraytags`
--
ALTER TABLE `spraytags`
  MODIFY `spraytag_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strawman_logs`
--
ALTER TABLE `strawman_logs`
  MODIFY `strawman_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ucp_applications`
--
ALTER TABLE `ucp_applications`
  MODIFY `ucp_application_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ucp_requests`
--
ALTER TABLE `ucp_requests`
  MODIFY `ucp_request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_sqlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_saved_mods`
--
ALTER TABLE `vehicle_saved_mods`
  MODIFY `vehicle_saved_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wardrobes`
--
ALTER TABLE `wardrobes`
  MODIFY `wardrobe_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
