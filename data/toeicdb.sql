-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th5 19, 2025 lúc 03:52 PM
-- Phiên bản máy phục vụ: 5.7.31
-- Phiên bản PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `toeicdb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam`
--

DROP TABLE IF EXISTS `exam`;
CREATE TABLE IF NOT EXISTS `exam` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration_minutes` int(11) NOT NULL,
  `difficulty_level` int(11) NOT NULL,
  PRIMARY KEY (`exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exam`
--

INSERT INTO `exam` (`exam_id`, `title`, `type`, `duration_minutes`, `difficulty_level`) VALUES
(1, 'New Economy TOEIC Test 1', 'Reading', 100, 1),
(2, 'New Economy TOEIC Test 2', 'Reading', 100, 1),
(3, 'New Economy TOEIC Test 3', 'Reading', 80, 2),
(4, '	\r\nNew Economy TOEIC Test Listening 1', 'Listening', 100, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_question`
--

DROP TABLE IF EXISTS `exam_question`;
CREATE TABLE IF NOT EXISTS `exam_question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `audio_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correct_answer` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_4` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passage_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`question_id`),
  KEY `exam_id` (`exam_id`) USING BTREE,
  KEY `Pass` (`passage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=363 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exam_question`
--

INSERT INTO `exam_question` (`question_id`, `exam_id`, `content`, `audio_url`, `correct_answer`, `option_1`, `option_2`, `option_3`, `option_4`, `passage_id`) VALUES
(155, 1, 'Its…………into Brazil has given Darrow Textiles Ltd. an advantage over much of its competition.', NULL, 'A', 'expansion', 'process', 'creation', 'action', NULL),
(156, 1, 'Employees at NC media co., Ltd…………donate to local charities by hosting Fund-raising parties.', NULL, 'D', 'regularity', 'regularize', 'regularities', 'regularly', NULL),
(157, 1, 'From winning an Olympic gold medal in 2000 to becoming an NBA champion in 2008, Kevin Garnet has shown…………to be one of the most talented players.', NULL, 'D', 'he', 'him', 'himself', 'his', NULL),
(158, 1, 'An accurate…………of surveys is imperative to building a good understanding of customer needs.', NULL, 'D', 'opportunity', 'contract', 'destination', 'analysis', NULL),
(159, 1, 'QIB will work…………to maintain sustainable growth and expansion plans.', NULL, 'C', 'Persisted', 'Persistent', 'Persistently', 'Persistence', NULL),
(160, 1, 'The president has just realized that the launch of our new product must be postponed owing to…………conditions in the market.', NULL, 'B', 'unwilling', 'unfavorable', 'opposing', 'reluctant', NULL),
(161, 1, 'A letter…………by a copy of the press release was mailed to the public relations department yesterday.', NULL, 'C', 'accompanies', 'accompanying', 'accompanied', 'will accompany', NULL),
(162, 1, 'The announcement of John Stanton\'s retirement was not well received by most of the staff members, but Leslie, his long time friend and colleague, was extremely …….to hear that Mr Stanton will now be able to enjoy some leisure time.', NULL, 'D', 'happiest', 'happily', 'happier', 'happy', NULL),
(163, 1, 'Nevada Jobfind Inc. is planning to host a career fair for college graduates seeking…………in the healthcare sector.', NULL, 'B', 'employ', 'employment', 'employee', 'employing', NULL),
(164, 1, 'The manager has asked Mr. Lim to submit his final report on the sales of the new washing machine…………April 30 th .', NULL, 'D', 'with', 'toward', 'between', 'by', NULL),
(165, 1, 'Following the visit to your production facility in Hong Kong next week, we………….a comprehensive factory automation program to meet your company\'s needs.', NULL, 'A', 'will create', 'was created', 'having created', 'had been creating', NULL),
(166, 1, 'Any employers or contractors who are found to have…………safety laws will be subject to a heavy fine.', NULL, 'C', 'complied', 'observed', 'breached', 'adhered', NULL),
(167, 1, 'Mr. Tanaka decided to resign, because a significant drop in customer satisfaction has had an adverse impact on sales…………', NULL, 'D', 'grower', 'grow', 'grown', 'growth', NULL),
(168, 1, '………his appointment as our head of accounting services, Paul Robinson was working as a high-powered merchant banker in London.', NULL, 'B', 'Since', 'Prior to', 'Except', 'Because', NULL),
(169, 1, 'We believe that the popularity of …………products is the result of a combination of beauty and functionality.', NULL, 'C', 'Us', 'We', 'Our', 'Ours', NULL),
(170, 1, '………his falling out with his former employer, Mr. Lee still meets with some of his old co-workers from time to time.', NULL, 'D', 'Subsequently', 'However', 'Meanwhile', 'Despite', NULL),
(171, 1, 'Library users must remove all…………belongings when they leave the library for more than a half hour.', NULL, 'B', 'unlimited', 'personal', 'accurate', 'believable', NULL),
(172, 1, 'Personnel changes within the marketing department …………no surprise, as it completely failed to meet the target on the most recent project.', NULL, 'B', 'made of', 'came as', 'spoke of', 'came across', NULL),
(173, 1, '………anyone wish to access the information the status of his or her order, the password should be entered.', NULL, 'B', 'If', 'Should', 'Whether', 'As though', NULL),
(174, 1, 'The latest training…………contains tips on teaching a second language to international students.', NULL, 'B', 'method', 'guide', 'staff', 'role', NULL),
(175, 1, 'The more we spent with the sales team, the more…………we were with their innovative marketing skills.', NULL, 'D', 'impression', 'impress', 'impresses', 'impressed', NULL),
(176, 1, '………Mega Foods imports only one kind of cheese now, the company will be importing a total of five varieties by next year.', NULL, 'B', 'Until', 'Once', 'Unless', 'Although', NULL),
(177, 1, 'Anyone…………experiences complications with the new software is encouraged to bring this matter to Mr. Gruber\'s attention in room 210.', NULL, 'A', 'Who', 'Which', 'Whom', 'whose', NULL),
(178, 1, 'Fast………….in computer technology have made it possible for the public to access a second-to-none amount of news and information.', NULL, 'C', 'Inspections', 'Belongings', 'Advances', 'Commitments', NULL),
(179, 1, 'Whether it is………….to register for a student discount card depends on the needs of the individual.', NULL, 'A', 'necessary', 'necessarily', 'necessitate', 'necessity', NULL),
(180, 1, 'As space is limited, be sure to contact Bill in the personnel department a minimum of three days in advance to…………for a workshop.', NULL, 'C', 'approve', 'express', 'register', 'record', NULL),
(181, 1, 'Ms. Walters was…………to make a presentation on how to increase revenue when I entered the room.', NULL, 'D', 'nearly', 'off', 'close', 'about', NULL),
(182, 1, 'Considering her ability, dedication, and expertise, I am…………that Ms. Yoko will be the most suitable person for the position of marketing manager.', NULL, 'A', 'Confident', 'Obvious', 'Noticeable', 'Intelligent', NULL),
(183, 1, '………the workload is very high at the moment, all the team members are optimistic that they will be able to finish the required work on time.', NULL, 'A', 'Even though', 'According to', 'As if', 'In order for', NULL),
(184, 1, 'Because the store was………… located, it had a huge advantage in exposing its goods to the public, which had an impact on its increase in sales.', NULL, 'C', 'center', 'central', 'centrally', 'centered', NULL),
(185, 1, '………the city council has approved the urban renewal project, we need to recruit several new workers.', NULL, 'D', 'If so', 'Rather than', 'Owing to', 'Given that', NULL),
(186, 1, 'The technicians…………tested all air-conditioning units to ensure that the cooling system is running smoothly.', NULL, 'A', 'systematically', 'exceedingly', 'increasingly', 'lastly', NULL),
(187, 1, 'We have…………confidence in the product\'s ability to provide unrivaled protection in an exposed blast environment.', NULL, 'D', 'productive', 'eventual', 'informative', 'absolute', NULL),
(188, 1, 'The marketers make an…………of products that attract a wide variety of potential customers.', NULL, 'A', 'array', 'alleviation', 'origin', 'extension', NULL),
(189, 1, 'Newer branches can be opened worldwide…………we can properly translate our marketing goals.', NULL, 'A', 'as soon as', 'right away', 'promptly', 'in time for', NULL),
(190, 1, 'Despite the fact that the new…………was developed by MIN Communications, its parent company received all the credit for it.', NULL, 'A', 'technology', 'technologies', 'technological', 'technologists', NULL),
(191, 1, 'Greg O\'Leary has been leading research in our laboratories…………over eighteen years.', NULL, 'B', 'in', 'for', 'up', 'from', NULL),
(192, 1, 'Library and information science majors should be reminded of the seminar beginning…………at 6:00 p.m in room 212B.', NULL, 'A', 'promptly', 'prompts', 'prompter', 'prompted', NULL),
(193, 1, 'The meteorological agency recommended that tourists to the region be…………dressed for frigid conditions.', NULL, 'B', 'suitable', 'suitably', 'suitability', 'suitableness', NULL),
(194, 1, 'The letter from Ms. Win seems to have disappeared without a…………', NULL, 'C', 'whisper', 'peep', 'trace', 'flash', NULL),
(195, 1, 'Why is the LBA holding a meeting?', NULL, 'B', 'To review its bylaws', 'To revise its voting procedures', 'To inspire new members to join', 'To choose a new president', 1),
(196, 1, 'If Ms. LeChevre cannot attend the meeting, what should she do?', NULL, 'A', 'Complete a mail-in ballot', 'Send an apology letter to the president', 'Make a financial contribution to the LBA', 'Run for president', 1),
(197, 1, 'What is attached to the letter?', NULL, 'C', 'LBA\'s budget status', 'A annual calendar of events', 'Profiles of those running for president', 'A directory of small businesses', 1),
(198, 1, 'What can be inferred about Ms. LeChevre?', NULL, 'D', 'She wants to be president.', 'She works for the president.', 'She takes charge of counting the ballots.', 'She is a member of the LBA', 1),
(199, 1, 'What kind of place is SkyCity?', NULL, 'A', 'A restaurant', 'A ship', 'A museum', 'A theme park', 2),
(200, 1, 'When could you go with a party of 12 people?', NULL, 'B', 'February 2nd, without needing a reservation', 'June 24th, with a reservation', 'May 3rd, with a reservation', 'You cannot go with a group of 12 people', 2),
(201, 1, 'What time On Friday can you NOT reserve a table?', NULL, 'D', '10am', '2pm', '9pm', '10pm', 2),
(202, 1, 'Former Sendai Company CEO Ken Nakata spoke about _________ career experiences.', NULL, 'B', 'he', 'his', 'him', 'himself', 3),
(203, 1, 'Passengers who will be taking a _________ domestic flight should go to Terminal A.', NULL, 'D', 'connectivity', 'connects', 'connect', 'connecting', 3),
(204, 1, 'Fresh and _________ apple-cider donuts are available at Oakcrest Orchard’s retail shop for £6 per dozen.', NULL, 'C', 'eaten', 'open', 'tasty', 'free', 3),
(205, 1, 'Zahn Flooring has the widest selection of _________ in the United Kingdom.', NULL, 'B', 'paints', 'tiles', 'furniture', 'curtains', 3),
(206, 1, 'One responsibility of the IT department is to ensure that the company is using _________ software.', NULL, 'D', 'update', 'updating', 'updates', 'updated', 3),
(207, 1, 'It is wise to check a company’s dress code _________ visiting its head office.', NULL, 'D', 'so', 'how', 'like', 'before', 3),
(208, 1, 'Wexler Store’s management team expects that employees will _________ support any new hires.', NULL, 'A', 'enthusiastically', 'enthusiasm', 'enthusiastic', 'enthused', 3),
(209, 1, 'Wheel alignments and brake system _________ are part of our vehicle service plan.', NULL, 'D', 'inspects', 'inspector', 'inspected', 'inspections', 3),
(210, 1, 'Registration for the Marketing Coalition Conference is now open _________ September 30.', NULL, 'A', 'until', 'into', 'yet', 'while', 3),
(211, 1, 'Growth in the home entertainment industry has been _________ this quarter.', NULL, 'B', 'separate', 'limited', 'willing', 'assorted', 3),
(212, 1, 'Hawson Furniture will be making _________ on the east side of town on Thursday.', NULL, 'A', 'deliveries', 'delivered', 'deliver', 'deliverable', 3),
(213, 1, 'The Marlton City Council does not have the authority to _________ parking on city streets.', NULL, 'B', 'drive', 'prohibit', 'bother', 'travel', 3),
(214, 1, 'Project Earth Group is _________ for ways to reduce transport-related greenhouse gas emissions.', NULL, 'A', 'looking', 'seeing', 'driving', 'leaning', 3),
(215, 1, 'Our skilled tailors are happy to design a custom-made suit that fits your style and budget _________.', NULL, 'C', 'perfect', 'perfects', 'perfectly', 'perfection', 3),
(216, 1, 'Project manager Hannah Chung has proved to be very _________ with completing company projects.', NULL, 'D', 'helpfulness', 'help', 'helpfully', 'helpful', 3),
(217, 1, 'Lehua Vacation Club members will receive double points _________ the month of August at participating hotels.', NULL, 'C', 'onto', 'above', 'during', 'between', 3),
(218, 1, 'The costumes were not received _________ enough to be used in the first dress rehearsal.', NULL, 'D', 'far', 'very', 'almost', 'soon', 3),
(219, 1, 'As a former publicist for several renowned orchestras, Mr. Wu would excel in the role of event _________.', NULL, 'B', 'organized', 'organizer', 'organizes', 'organizational', 3),
(220, 1, 'The northbound lane on Davis Street will be _________ closed because of the city’s bridge reinforcement project.', NULL, 'A', 'temporarily', 'competitively', 'recently', 'collectively', 3),
(221, 1, 'Airline representatives must handle a wide range of passenger issues, _________ missed connections to lost luggage.', NULL, 'A', 'from', 'under', 'on', 'against', 3),
(222, 1, 'The meeting notes were _________ deleted, but Mr. Hahm was able to recreate them from memory.', NULL, 'D', 'accident', 'accidental', 'accidents', 'accidentally', 3),
(223, 1, 'The current issue of Farming Scene magazine predicts that the price of corn will rise 5 percent over the _________ year.', NULL, 'A', 'next', 'with', 'which', 'now', 3),
(224, 1, 'Anyone who still _________ to take the fire safety training should do so before the end of the month.', NULL, 'B', 'needing', 'needs', 'has needed', 'were needing', 3),
(225, 1, 'Emerging technologies have _________ begun to transform the shipping industry in ways that were once unimaginable.', NULL, 'A', 'already', 'exactly', 'hardly', 'closely', 3),
(226, 1, 'The company handbook outlines the high _________ that employees are expected to meet every day.', NULL, 'D', 'experts', 'accounts', 'recommendations', 'standards', 3),
(227, 1, 'Because _________ of the board members have scheduling conflicts, the board meeting will be moved to a date when all can attend.', NULL, 'D', 'any', 'everybody', 'those', 'some', 3),
(228, 1, 'The project _________ the collaboration of several teams across the company.', NULL, 'C', 'passed', 'decided', 'required', 'performed', 3),
(229, 1, 'We cannot send the store’s coupon booklet to the printers until it _________ by Ms. Jeon.', NULL, 'C', 'is approving', 'approves', 'has been approved', 'will be approved', 3),
(230, 1, '_________ the closure of Verdigold Transport Services, we are looking for a new shipping company.', NULL, 'C', 'In spite of', 'Just as', 'In light of', 'According to', 3),
(231, 1, 'The _________ information provided by Uniss Bank’s brochure helps applicants understand the terms of their loans.', NULL, 'B', 'arbitrary', 'supplemental', 'superfluous', 'potential', 3),
(232, 2, 'What is being advertised?', NULL, 'C', 'A vacation rental', 'A new hotel', 'An event space', 'A summer camp', 4),
(233, 2, 'What will be offered on October 10?', NULL, 'D', 'A discounted reservation rate', 'A special concert', 'A famous recipe book', 'A class by a famous chef', 4),
(234, 2, 'Before operating your handheld device, please __________ the enclosed cable to charge it.', NULL, 'C', 'plan', 'remain', 'use', 'finish', NULL),
(235, 2, 'Safile\'s new external hard drive can __________ store up to one terabyte of data.', NULL, 'C', 'secure', 'security', 'securely', 'secured', NULL),
(236, 2, 'Mr. Peterson will travel __________ the Tokyo office for the annual meeting.', NULL, 'A', 'to', 'through', 'in', 'over', NULL),
(237, 2, 'Yong-Soc Cosmetics will not charge for items on back order until __________ have left our warehouse.', NULL, 'B', 'them', 'they', 'themselves', 'their', NULL),
(238, 2, 'Our premium day tour takes visitors to historic sites __________ the Aprico River.', NULL, 'D', 'onto', 'since', 'inside', 'along', NULL),
(239, 2, 'Eighty percent of drivers surveyed said they would consider buying a vehicle that runs on __________.', NULL, 'A', 'electricity', 'electrically', 'electricians', 'electrify', NULL),
(240, 2, 'Xinzhe Zu has __________ Petrin Engineering as the vice president of operations.', NULL, 'C', 'attached', 'resigned', 'joined', 'combined', NULL),
(241, 2, 'Next month, Barder House Books will be holding __________ third author\'s hour in Cleveland.', NULL, 'D', 'it', 'itself', 'its own', 'its', NULL),
(242, 2, 'Chester’s Tiles __________ expanded to a second location in Turnington.', NULL, 'C', 'severely', 'usually', 'recently', 'exactly', NULL),
(243, 2, 'Tabrino\'s has __________ increased the number of almonds in the Nut Medley snack pack.', NULL, 'D', 'significant', 'significance', 'signifies', 'significantly', NULL),
(244, 2, '__________ she travels, Jacintha Flores collects samples of local fabrics and patterns.', NULL, 'A', 'Wherever', 'in addition to', 'Either', 'in contrast to', NULL),
(245, 2, 'Most picture __________ at Glowing Photo Lab go on sale at 3:00 PM. today.', NULL, 'D', 'framer', 'framing', 'framed', 'frames', NULL),
(246, 2, 'All students in the business management class hold __________ college degrees.', NULL, 'C', 'late', 'developed', 'advanced', 'elated', NULL),
(247, 2, 'We hired Noah Wan of Shengyao Accounting Ltd, __________ our company\'s financial assets.', NULL, 'A', 'to evaluate', 'to be evaluated', 'will be evaluated', 'evaluate', NULL),
(248, 2, 'Ms. Charisse is taking on a new account __________ she finishes the Morrison project.', NULL, 'C', 'with', 'going', 'after', 'between', NULL),
(249, 2, 'Cormet Motors\' profits are __________ this year than last year.', NULL, 'A', 'higher', 'high', 'highly', 'highest', NULL),
(250, 2, 'In its __________ advertising campaign. Jaymor Tools demonstrates how reliable its products are.', NULL, 'A', 'current', 'relative', 'spacious', 'collected', NULL),
(251, 2, 'Remember to submit receipts for reimbursement __________ returning from a business trip.', NULL, 'B', 'such as', 'when', 'then', 'within', NULL),
(252, 2, 'Patrons will be able to access Westside Library\'s __________ acquired collection of books on Tuesday.', NULL, 'B', 'instantly', 'newly', 'early', 'naturally', NULL),
(253, 2, 'Please __________ any questions about time sheets to Tabitha Jones in the payroll department.', NULL, 'D', 'direction', 'directive', 'directed', 'direct', NULL),
(254, 2, 'Before signing a delivery __________, be sure to double-check that all the items ordered are in the shipment.', NULL, 'C', 'decision', 'announcement', 'receipt', 'limit', NULL),
(255, 2, 'Funds have been added to the budget for expenses __________ with the new building.', NULL, 'A', 'associated', 'association', 'associate', 'associates', NULL),
(256, 2, 'Ms. Bernard __________ that a deadline was approaching. so she requested some assistance.', NULL, 'A', 'noticed', 'obscured', 'withdrew', 'appeared', NULL),
(257, 2, 'Mr. Moscowitz is __________ that Dr. Tanaka will agree to present the keynote speech at this year\'s conference.', NULL, 'C', 'hopes', 'hoped', 'hopeful', 'hopefully', NULL),
(258, 2, 'Two Australian companies are developing new smartphones, but it is unclear __________ phone will become available first.', NULL, 'B', 'if', 'which', 'before', 'because', NULL),
(259, 2, 'Corners Gym offers its members a free lesson in how to use __________ property.', NULL, 'B', 'weighs', 'weights', 'weighty', 'weighed', NULL),
(260, 2, '__________ the rules, overnight parking is not permitted at the clubhouse facility.', NULL, 'D', 'Prior to', 'Except for', 'Instead of', 'According to', NULL),
(261, 2, 'Once everyone __________, we can begin the conference call.', NULL, 'D', 'arrived', 'is arriving', 'to arrive', 'has arrived', NULL),
(262, 2, 'Each summer a motivational video that highlights the past year\'s __________ is shown to all company employees.', NULL, 'B', 'preferences', 'accomplishments', 'communications', 'uncertainties', NULL),
(263, 2, 'Employees who wish to attend the retirement dinner __________ Ms. Howell\'s 30 years of service should contact Mr. Lee.', NULL, 'B', 'honor', 'to honor', 'will honor', 'will be honored', NULL),
(264, 2, '139.', NULL, 'B', 'agree', 'vary', 'wait', 'decline', 5),
(265, 2, '140.', NULL, 'C', 'receiving', 'having received', 'received', 'will be received', 5),
(266, 2, '141.', NULL, 'D', 'The updated price list will be available on March 20.', 'We apologize for this inconvenience.', 'Your orders will be shipped after April 17.', 'We are increasing prices because of rising costs.', 5),
(267, 2, '142.', NULL, 'A', 'exceptionally', 'exception', 'exceptional', 'exceptionalism', 5),
(268, 2, '143.', NULL, 'C', 'patients', 'students', 'customers', 'teammates', 6),
(269, 2, '144.', NULL, 'D', 'If you need more time, please let me know.', 'Unfortunately, I do not have adequate shelf space at this time.', 'I would like to show you some of my own designs.', 'The reasonable prices also make your pieces a great value.', 6),
(270, 2, '145.', NULL, 'A', 'include', 'double', 'repeat', 'insure', 6),
(271, 2, '146.', NULL, 'B', 'us', 'you', 'we', 'these', 6),
(272, 2, 'When filling out the order form, please ____________ your address clearly to prevent delays.', NULL, 'B', 'fix', 'write', 'send', 'direct', NULL),
(275, 2, 'The free clinic was founded by a group of doctors to give ____________ for various medical conditions.', NULL, 'A', 'treatment', 'treat', 'treated', 'treating', NULL),
(278, 2, 'The figures that accompany the financial statement should be ____________ to the spending %\' category.', NULL, 'D', 'relevance', 'relevantly', 'more relevantly', 'relevant', NULL),
(279, 2, 'The building owner purchased the property ____________ three months ago, but she has already spent a great deal of money on renovations.', NULL, 'B', 'yet', 'just', 'few', 'still', NULL),
(280, 2, 'We would like to discuss this problem honestly and ____________ at the next staff meeting.', NULL, 'C', 'rarely', 'tiredly', 'openly', 'highly', NULL),
(281, 2, 'The store\'s manager plans to put the new merchandise on display ____________ to promote the line of fall fashions.', NULL, 'A', 'soon', 'very', 'that', 'still', NULL),
(282, 2, 'During the peak season, it is ____________ to hire additional workers for the weekend shifts.', NULL, 'C', 'necessitate', 'necessarily', 'necessary', 'necessity', NULL),
(283, 2, 'Now that the insulation has been replaced, the building is much more energy-efficient.', NULL, 'A', 'Now', 'For', 'As', 'Though', NULL),
(284, 2, 'Mr. Sims needs a more ____________ vehicle for commuting from his suburban home to his office downtown.', NULL, 'B', 'expressive', 'reliable', 'partial', 'extreme', NULL),
(285, 2, 'The company ____________ lowered its prices to outsell its competitors and attract more customers.', NULL, 'B', 'strategy', 'strategically', 'strategies', 'strategic', NULL),
(286, 2, 'Before Mr. Williams addressed the audience, he showed a brief video about the engine he had designed.', NULL, 'C', 'Then', 'So that', 'Before', 'Whereas', NULL),
(287, 2, 'For optimal safety on the road, avoid ____________ the view of the rear window and side-view mirrors.', NULL, 'D', 'obstructs', 'obstructed', 'obstruction', 'obstructing', NULL),
(288, 2, 'Having proper ventilation throughout the building is ___________ for protecting the health and well-being of the workers.', NULL, 'C', 'cooperative', 'visible', 'essential', 'alternative', NULL),
(289, 2, 'The fact that sales of junk food have been steadily declining indicates that consumers are becoming more health-conscious.', NULL, 'B', 'In addition to', 'The fact that', 'As long as', 'In keeping with', NULL),
(290, 2, 'The sprinklers for the lawn\'s irrigation system are ___________ controlled.', NULL, 'A', 'mechanically', 'mechanic', 'mechanism', 'mechanical', NULL),
(291, 2, 'The library staff posted signs to ___________ patrons of the upcoming closure for renovations.', NULL, 'A', 'notify', 'agree', 'generate', 'perform', NULL),
(292, 2, 'Mr. Ross, ___________ is repainting the interior of the lobby, was recommended by a friend of the building manager.', NULL, 'C', 'himself', 'he', 'who', 'which', NULL),
(293, 2, 'The guidelines for the monthly publication are ___________ revised to adapt to the changing readers.', NULL, 'C', 'courteously', 'initially', 'periodically', 'physically', NULL),
(294, 2, 'In spite of an ankle injury, the baseball player participated in the last game of the season.', NULL, 'A', 'In spite of', 'Even if', 'Whether', 'Given that', NULL),
(295, 2, 'The governmental department used to provide financial aid, but now it offers ___________ services only.', NULL, 'A', 'legal', 'legalize', 'legally', 'legalizes', NULL),
(296, 2, 'At the guest\'s ___________ , an extra set of towels and complimentary soaps were brought to the room.', NULL, 'C', 'quote', 'graduation', 'request', 'dispute', NULL),
(297, 2, 'The upscale boutique Jane\'s Closet is known for selling the most stylish ___________ for young professionals.', NULL, 'D', 'accessorized', 'accessorize', 'accessorizes', 'accessories', NULL),
(298, 2, 'The company started to recognize the increasing ___________ of using resources responsibly.', NULL, 'C', 'more important', 'importantly', 'importance', 'important', NULL),
(299, 2, 'After restructuring several departments within the company, the majority of the problems with miscommunication have disappeared.', NULL, 'A', 'After', 'Until', 'Below', 'Like', NULL),
(300, 2, 'The riskiest ___________ of the development of new medications are the trials with human subjects.', NULL, 'D', 'proceeds', 'perspectives', 'installments', 'stages', NULL),
(301, 2, 'Anyone seeking a position at Tulare Designs must submit a portfolio of previous work.', NULL, 'A', 'Anyone', 'Whenever', 'Other', 'Fewer', NULL),
(302, 2, '', NULL, 'A', 'Throughout the trial, you pay nothing and sign no contract.', 'Weight-lifting classes are not currently available.', 'A cash deposit is required when you sign up for membership.', 'All questions should be e-mailed to customerservice@gsgym.com.', 7),
(303, 2, '', NULL, 'D', 'not even', 'almost', 'over', 'less than', 7),
(304, 2, '', NULL, 'B', 'justly', 'regularly', 'evenly', 'simply', 7),
(305, 2, '', NULL, 'C', 'extend', 'renew', 'cancel', 'initiate', 7),
(306, 2, '', NULL, 'C', 'cost', 'delay', 'decision', 'forecast', 8),
(307, 2, '', NULL, 'D', 'Such a figure is unprecedented in the company\'s history.', 'Moreover, Ms. Seiler holds an advanced degree in economics.', 'Pecans are high in vitamins and minerals.', 'Still, MKZ shares have been profitable in recent years.', 8),
(308, 2, '', NULL, 'B', 'on', 'for', 'in', 'by', 8),
(309, 2, '', NULL, 'D', 'farming', 'farmer', 'farmed', 'farm', 8),
(314, 2, 'York Development Corporation marked the ______ of the Ford Road office complex with a ribbon-cutting ceremony.', NULL, 'B', 'opens', 'opening', 'opened', 'openly', NULL),
(315, 2, 'Staff at the Bismarck Hotel were ______ helpful to us during our stay.', NULL, 'A', 'quite', 'enough', 'far', 'early', NULL),
(316, 2, 'Ms. Luo will explain some possible consequences of the ______ merger with the Wilson-Peek Corporation.', NULL, 'A', 'proposed', 'proposal', 'proposition', 'proposing', NULL),
(317, 2, 'The Springdale supermarket survey ______ will be released a week after they are evaluated.', NULL, 'C', 'events', 'stores', 'results', 'coupons', NULL),
(318, 2, 'The new printer operates more ______ than the previous model did.', NULL, 'D', 'quickest', 'quickness', 'quick', 'quickly', NULL),
(319, 2, 'Here at Vanguard Buying Club, ______ help members find quality merchandise at the lowest possible prices.', NULL, 'C', 'us', 'our', 'we', 'ourselves', NULL),
(320, 2, 'Management announced that all salespeople would be receiving a bonus this year, ______ in time for summer vacations.', NULL, 'A', 'just', 'as', 'only', 'by', NULL),
(321, 2, 'According to Florida Digital Designer Magazine, many graphic designers do not consider ______ to be traditional artists.', NULL, 'C', 'it', 'their', 'themselves', 'itself', NULL),
(322, 2, 'A wooden bridge crossing the wading pond ______ to the hotel\'s nine-hole golf course.', NULL, 'B', 'prepares', 'leads', 'presents', 'takes', NULL),
(323, 2, 'A special sale on stationery ______ on the Write Things Web site yesterday.', NULL, 'A', 'was announced', 'announced', 'was announcing', 'to announce', NULL),
(324, 2, 'All produce transported by Gocargo Trucking is refrigerated ______ upon pickup to prevent spoilage.', NULL, 'B', 'lately', 'promptly', 'potentially', 'clearly', NULL),
(325, 2, 'The Ferrera Museum plans to exhibit a collection of Lucia Almeida’s most ______ sculptures.', NULL, 'A', 'innovative', 'innovation', 'innovatively', 'innovate', NULL),
(326, 2, 'The bank’s cashier windows are open daily from 8:00 A.M. to 4:00 P.M. ______ on Sundays.', NULL, 'A', 'except', 'until', 'nor', 'yet', NULL),
(327, 2, 'Inventory control and warehousing strategies ______ within the responsibilities of the supply chain manager.', NULL, 'D', 'have', 'cover', 'mark', 'fall', NULL),
(328, 2, 'Of all the truck models available today, it can be difficult to figure out ______ would best suit your company’s needs.', NULL, 'C', 'when', 'why', 'which', 'where', NULL),
(329, 2, 'CEO Yoshiro Kasai has expressed complete faith in Fairway Maritime’s ______ to deliver the product on time.', NULL, 'D', 'belief', 'measure', 'problem', 'ability', NULL),
(330, 2, 'At Derwin Securities, trainees alternate ______ attending information sessions and working closely with assigned mentors.', NULL, 'C', 'along', 'against', 'between', 'near', NULL),
(331, 2, 'Company Vice President Astrid Barretto had no ______ to being considered for the position of CEO.', NULL, 'D', 'objected', 'objecting', 'objects', 'objection', NULL),
(332, 2, 'Belinda McKay fans who are ______ to the author’s formal writing style will be surprised by her latest biography.', NULL, 'D', 'fortunate', 'readable', 'comparable', 'accustomed', NULL),
(333, 2, 'The Southeast Asia Business Convention will feature ______ known and respected leaders from countries across the region.', NULL, 'C', 'widen', 'wider', 'widely', 'wide', NULL),
(334, 2, '______ the high cost of fuel, customers are buying smaller, more efficient cars.', NULL, 'D', 'Together with', 'Instead of', 'As well as', 'Because of', NULL),
(335, 2, 'Over the past ten years, Bellworth Medical Clinic ______ Atlan Protection officers for all security needs.', NULL, 'C', 'is hiring', 'were hiring', 'has hired', 'was hired', NULL),
(336, 2, 'What is the purpose of the article?', NULL, 'B', 'To promote a technology show', 'To introduce a product', 'To interview smartphone users', 'To announce a recall of a device', 9),
(337, 2, 'How much do the Gorman Pro Phone 4 wireless headphones cost?', NULL, 'C', '£39', '£59', '£79', '£100', 9),
(338, 2, 'What does the Pro Phone 4 have in common with prior models?', NULL, 'D', 'The screen size', 'The camera resolution', 'The price', 'The charger', 9),
(339, 2, 'In which of the positions marked [1], [2], [3], and [4] does the following sentence best belong? \"These upgrades do come at a cost.\"', NULL, 'C', '[1]', '[2]', '[3]', '[4]', 9),
(340, 1, '139.', NULL, 'A', 'offering', 'accepting', 'discussing', 'advertising', 10),
(341, 1, '140.', NULL, 'D', 'accompany', 'did accompany', 'accompanies', 'will accompany', 10),
(342, 1, '141.', NULL, 'B', 'too', 'also', 'as well as', 'additionally', 10),
(343, 1, '142.', NULL, 'D', 'Please sign all the documents.', 'I will provide you with a replacement.', 'Construction will be completed next year.', 'You can download one from our Web site.', 10),
(344, 1, 'What is suggested about the company Ms. Chichester works for?', NULL, 'A', 'It currently has no large-sized shirts in stock.', 'It has filled an order for Mr. Gerew before.', 'It offers discounts on large orders.', 'It is open every evening.', 11),
(345, 1, 'Why is Mr. Gerew ordering new shirts?', NULL, 'B', 'Additional staff members have been hired.', 'More were sold than had been anticipated.', 'The company’s logo has been changed.', 'The style currently in use has become outdated.', 11),
(346, 1, 'At 1:38 P.M., what does Mr. Gerew mean when he writes, “I guess it can’t be helped”?', NULL, 'A', 'He will pay a $75 rush-order fee.', 'He will ask his assistant to help him.', 'He will meet Ms. Chichester at 1:00 P.M.', 'He will select the standard production option.', 11),
(347, 1, 'What will Mr. Gerew likely do next?', NULL, 'A', 'Provide payment information to Ms. Chichester', 'Schedule a meeting with Ms. Chichester', 'Send an e-mail to Ms. Chichester', 'Fix Ms. Chichester’s computer', 11),
(348, 1, 'The regional manager will arrive tomorrow, so please ensure that all ----------------- documents are ready.', NULL, 'B', 'she', 'her', 'hers', 'herself', NULL),
(349, 1, 'The historic Waldridge Building was constructed nearly 200 years -----------------.', NULL, 'C', 'away', 'enough', 'ago', 'still', NULL),
(350, 1, 'Consumers ------------- enthusiastically to the new colors developed by Sanwell Paint.', NULL, 'D', 'responding', 'response', 'responsively', 'responded', NULL),
(351, 1, 'The ---------------------------files contain your employment contract and information about our company.', NULL, 'B', 'directed', 'attached', 'interested', 'connected', NULL),
(352, 1, 'Please submit each reimbursement request ----------------- according to its category, as outlined in last month’s memo.', NULL, 'A', 'separately', 'separateness', 'separates', 'separate', NULL),
(353, 1, 'Customers can wait in the reception area ------------ our mechanics complete the car repairs.', NULL, 'C', 'whether', 'except', 'while', 'during', NULL),
(354, 1, 'No one without a pass will be granted ---------------- to the conference.', NULL, 'A', 'admission', 'is admitting', 'admitted', 'to admit', NULL),
(355, 1, 'To receive an electronic reminder when payment is due, set up an online account ---------------- Albright Bank.', NULL, 'D', 'of', 'about', 'over', 'with', NULL),
(356, 1, 'The registration fee is ---------------- refundable up to two weeks prior to the conference date.', NULL, 'C', 'fullest', 'fuller', 'fully', 'full', NULL),
(357, 1, 'All identifying information has been ------------------ from this letter of complaint so that it can be used for training purposes.', NULL, 'C', 'produced', 'extended', 'removed', 'resolved', NULL),
(358, 1, '----------------- this time next year, Larkview Technology will have acquired two new subsidiaries.', NULL, 'B', 'To', 'By', 'Quite', 'Begin', NULL),
(359, 1, 'Table reservations for ------------------ greater than ten must be made at least one day in advance.', NULL, 'D', 'plates', 'meals', 'sizes', 'parties', NULL),
(360, 1, 'Because of --------------- weather conditions, tonight\'s concert in Harbin Park has been canceled.', NULL, 'A', 'worsening', 'worsens', 'worsen', 'worst', NULL),
(361, 1, 'Ms. Al-Omani will rely ------------------------- team leaders to develop employee incentive programs.', NULL, 'D', 'onto', 'into', 'within', 'upon', NULL),
(362, 1, 'Survey ------------------------- analyze the layout of a land area above and below ground level.', NULL, 'A', 'technicians', 'technically', 'technical', 'technicality', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_result`
--

DROP TABLE IF EXISTS `exam_result`;
CREATE TABLE IF NOT EXISTS `exam_result` (
  `result_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `listening_score` int(11) NOT NULL,
  `reading_score` int(11) NOT NULL,
  `total_score` int(11) NOT NULL,
  `time` date NOT NULL,
  PRIMARY KEY (`result_id`),
  KEY `User_id` (`user_id`),
  KEY `FK_exam1` (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pracetice_result`
--

DROP TABLE IF EXISTS `pracetice_result`;
CREATE TABLE IF NOT EXISTS `pracetice_result` (
  `practice_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `time_finish` date NOT NULL,
  PRIMARY KEY (`practice_id`),
  KEY `FK_session` (`session_id`),
  KEY `FK_Userid11` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pracetice_session`
--

DROP TABLE IF EXISTS `pracetice_session`;
CREATE TABLE IF NOT EXISTS `pracetice_session` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reading_passage`
--

DROP TABLE IF EXISTS `reading_passage`;
CREATE TABLE IF NOT EXISTS `reading_passage` (
  `passage_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `content` varchar(16381) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`passage_id`),
  KEY `FK_Exam11` (`exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reading_passage`
--

INSERT INTO `reading_passage` (`passage_id`, `exam_id`, `content`) VALUES
(1, 1, 'LBA\r\n\r\nLocal Businesses of Albany\r\n121 S. Main St., Albany, NY 12019\r\n\r\nNovember 9\r\nDear Ms. LeChevre,\r\nWe would like to invite you to participate in our upcoming meeting, to be held on Wednesday,\r\nNovember 17 at 6:00 p.m. at the Hilton Suites. During this meeting we plan to hold an election\r\nfor the next LBA president, who will serve for the coming year. Past presidents will be present to\r\nexplain the importance of the position and to help facilitate the voting process. This year we have\r\nfour members interested in running for this position; please note that their professional profiles\r\nare attached. Make sure to review these profiles prior to the meeting. There will be a question-\r\nand-answer session with this year&#39;s candidates before voting begins.\r\nWe are anticipating a large turnout at this year&#39;s election, and hope that you will be able to join\r\nus on this important day. If, for some reason, you are unable to attend, we ask that you send in\r\nyour vote using the attached mail-in ballot. You can send the form to Local Businesses of\r\nAlbany, 121 S. Main St., Albany, NY 12019. Please make sure that your ballot arrives by\r\nNovember 17.\r\nOur bylaws state that a majority of the LBA&#39;s members must vote in the upcoming election in\r\norder for us to officially inaugurate a new president. Because of this, we ask that you make\r\nvoting a priority and either attend the meeting or send in your ballot by mail.\r\nSincerely,\r\nDavid Smith'),
(2, 1, 'RESERVATIONS\r\n\r\nTo ensure a table at SkyCity, at the top of Seattle’s Space Needle, reservations are\r\nrecommended.\r\nTo make a reservation call: 206-905-2100 or 800-938-9582.\r\nGroups are welcome but must be scheduled in advance and are limited to no more than 21\r\nguests. Parties of 10 or more cannot be accommodated May 31 through September 3.\r\nYour elevator ride and Observation Deck visit are complimentary with your reservation at\r\nSkyCity. Reservations are available for seating during the following hours:\r\nLunch Monday - Friday 11:00am – 3:00pm\r\nBrunch Saturday &amp; Sunday 10:00am – 3:00pm\r\nDinner Sunday – Thursday\r\nFriday &amp; Saturday\r\n\r\n5:00pm – 9:00pm\r\n5:00pm – 10:00pm'),
(3, 1, 'In the Reading test, you will read a variety of texts and answer several different types of reading comprehension questions. The entire Reading test will last 75 minutes. There are three parts, and directions are given for each part. You are encouraged to answer as many questions as possible within the time allowed.\r\nYou must mark your answers on the separate answer sheet. Do not write your answers in your test book.\r\nPART 5\r\nDirections: A word or phrase is missing in each of the sentences below. Four answer choices are given below each sentence. Select the best answer to complete the sentence. Then mark the letter (A), (B), (C), or (D) on your answer sheet.'),
(4, 2, 'Crescent Moon Bistro\r\nLocated along the eastern shore of Canawap Bay, the Crescent Moon Bistro is a unique venue for birthday parties, weddings, corporate gatherings, and a host of other social events. Our chefs work with you to craft a perfect menu, while our coordinators will see to it that your event is superbly organized. Rental pricing is based on the date, type of event, and number of attendees.\r\n\r\nYou are welcome to tour our facility on October 10 from 11:00 A.M. to 2:00 P.M. Meet with our coordinators and culinary staff, and sample items from our creative menu. Admission is free, but registration is required. We are offering 25% off on any booking made during this open house on October 10.'),
(5, 2, 'To: All Customers\r\nFrom: asquires@lightidea.com\r\nDate: March 6\r\nSubject: Information\r\n\r\nDear Light Idea Customers,\r\n\r\nLight Idea is enacting a price increase on select energy-efficient products, effective April 17. Specific product pricing will ____(139)_____. Please contact your sales representative for details and questions.\r\n\r\nThe last date for ordering at current prices is April 16. All orders ____(140)_____ after this date will follow the new price list ____(141)_____. Customers will be able to find this on our Web site.\r\n\r\nWe will continue to provide quality products and ____(142)_____ service to our valued customers. Thank you for your business.\r\n\r\nSincerely,\r\nArvin Squires\r\nHead of Sales, Light Idea'),
(6, 2, 'To: Jang-Ho Kwon <jkwon@newart.nz>\r\nFrom: Kenneth Okim <k.okim@okimjewelry.nz>\r\nSubject: Good news\r\nDate: 30 August\r\n\r\nDear Jang-Ho,\r\n\r\nThank you for the shipment last month of 80 units of your jewelry pieces. I am happy to report that they have been selling very well in my shop. My ____(143)_____ love the colourful designs as well as the quality of your workmanship____(144)_____.\r\n\r\nI would like to increase the number of units I order from you. Would you be able to ____(145)_____my order for the September shipment?\r\n\r\nFinally, I would like to discuss the possibility of featuring your work exclusively in my store. I believe that I could reach your target audience best and that the agreement would serve ____(146)_____both very well. I look forward to hearing from you.\r\n\r\nBest regards,\r\nKenneth Okim\r\nOkim Jewelry'),
(7, 2, 'With Global Strength Gym\'s 30-day trial period, you get the opportunity to try out our classes, equipment, and facilities ____(131)_____ . It\'s completely risk-free! To sign up, we require your contact information and payment details, but you will only be charged if you are a member for ____(132)_____ 30 days. If you decide within this time that you no longer want to be a member of Global Strength, ____(133)_____ visit our Web site at www.gsgym.com. On the Membership page, elect to ____(134)_____ your membership and enter the necessary information. It\'s that easy!'),
(8, 2, '(18 Aprii)-MKZ Foods, Inc., the region\'s largest exporter of pecans, expects its outgoing shipments to increase significantly over the next few months. This ____(143)_____ is based on the fact that the region\'s pecan farmers expanded their land area by 20 percent last year. According to spokesperson Katharina Seiler, MKZ\'s exports could reach a colossal 50,000 metric tons this year ____(144)_____\r\nMKZ buys most of the yield from the region\'s pecan farms and processes it ____(145)_____ export throughout the world. \"The availability of new land for ____(146)_____ in the region is creating opportunities for growth,\" said Ms. Seiler. \"I believe MKZ is going to have a truly outstanding year.\"'),
(9, 2, 'Gorman Unveils Newest Smartphone Model\r\nLONDON (20 April)—Gorman Mobile unveiled its newest smartphone to an eager reception at the annual Technobrit Conference. The Pro Phone 4, which includes 512 GB of storage, a 7-inch screen display, and an optional stylus pen, will hit the shelves on 11 June. Unlike its predecessor—the Pro Phone 3—it features a larger screen, an ultrawide camera lens, and 8K-resolution filming capability.\r\n\r\n—[1]—. The £999 starting price is £100 more than that of the previous model. Add-ons. such as the stylus pen. protective case, and wireless headphones, cost an additional £39. £59, and £79, respectively.\r\n\r\nGorman Product Manager Ian Hill doesn’t believe the price increase will dissuade customers. — [2] —.\r\n\r\n“The Pro Phone 4 is a game changer in terms of its picture quality and sleek design,” said Hill. “Improvements were based on direct customer feedback, which cited the poor camera functionality as the biggest drawback of prior models. Our clients spoke, and we listened and adapted accordingly.” — [3] —.\r\n\r\nOne similarity that the Pro Phone 4 has with previous models is the charger. Going against the trend of competing wireless companies, Gorman is instead focusing on convenience.\r\n\r\n“We want to afford our customers the ability to reuse elements of the other Gorman devices they’ve already purchased,” said Hill. “Why add to the overload of cables already in circulation?” — [4] —.'),
(10, 1, 'To: fcontini@attmail.com\r\nFrom: btakemoto@arolischems.co.uk\r\nDate: 15 July\r\nSubject: Your first day at Arolis\r\nDear Mr. Contini,\r\n\r\nWelcome to Arolis Chemicals! Thank you for ____(139)_____ the full-time, permanent position of laboratory assistant. We look forward to your arrival on 1 August in the Harris Building. Please report to the front desk and ask for Jack McNolan. He ____(140)_____ you to the Human Resources office. There, you will obtain your employee badge ____(141)_____ all documents necessary to start work. Note that because of its large size, the Leicester campus of Arolis can be difficult to navigate. Studying a campus map will help orient you to the location of the different buildings ____(142)_____ .\r\n\r\nShould you have any questions, please do not hesitate to contact me.\r\n\r\nSincerely,\r\n\r\nBrandon Takemoto\r\nHR Administrative Officer'),
(11, 1, 'Delroy Gerew (1:29 PM):\r\nHi, Ms. Chichester. we\'d like to order another 10 shirts, featuring the company\'s name, Magnalook, and its logo. We need four small, two medium, and four large sizes. Could you fill the order by Friday?\r\nNina Chichester (1:32 P.Nl.):\r\nThat\'s two days from today, so a $75 rush-order fee will be added.\r\nDelroy Gerew (1:34 PM):\r\nHow can we avoid the fee?\r\nNina Chichester (1:36 PM):\r\nBy choosing the standard 5-day production option. Your order would be ready Monday of next week.\r\nDelroy Gerew (1:38 P.M.):\r\nI guess it can\'t be helped. Since we have employees starting this Friday and you open at 8:00 AM, can I pick up the shirts at that time?\r\nNina Chichester (1:39 P.M.):\r\nPick-up time is normally after 1:00 PM, but I\'ll see to it they\'re ready by 8:00 AM.\r\nDelroy Gerew (1 :41 RM):\r\nThank you. Actually. my assistant will be picking them up.\r\nNina Chichester (1:42 P.M.):\r\nThat\'s fine. Could you please e-mail me your logo again? The computer on which I had it stored crashed the other day and is awaiting repair.\r\nDelroy Gerew (1:44 PM):\r\nWill do. Thanks, and please charge the credit card you have on file for us.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subcription`
--

DROP TABLE IF EXISTS `subcription`;
CREATE TABLE IF NOT EXISTS `subcription` (
  `subcription_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`subcription_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_sub` (`subscription_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `exam_question`
--
ALTER TABLE `exam_question`
  ADD CONSTRAINT `FK_Exam` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk_rdpass` FOREIGN KEY (`passage_id`) REFERENCES `reading_passage` (`passage_id`);

--
-- Các ràng buộc cho bảng `exam_result`
--
ALTER TABLE `exam_result`
  ADD CONSTRAINT `FK_exam1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_userid` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `pracetice_result`
--
ALTER TABLE `pracetice_result`
  ADD CONSTRAINT `FK_Userid11` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_session` FOREIGN KEY (`session_id`) REFERENCES `pracetice_session` (`session_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `reading_passage`
--
ALTER TABLE `reading_passage`
  ADD CONSTRAINT `FK_Exam11` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`);

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_sub` FOREIGN KEY (`subscription_id`) REFERENCES `subcription` (`subcription_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
