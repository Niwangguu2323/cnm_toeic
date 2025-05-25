-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th5 25, 2025 lúc 09:22 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exam`
--

INSERT INTO `exam` (`exam_id`, `title`, `type`, `duration_minutes`, `difficulty_level`) VALUES
(1, 'New Economy TOEIC Test 1', 'Reading', 3, 1),
(2, 'New Economy TOEIC Test 2', 'Reading', 100, 1),
(3, 'New Economy TOEIC Test 3', 'Reading', 80, 2),
(4, '	\r\nNew Economy TOEIC Test Listening 1', 'Listening', 100, 1),
(5, 'Test Economy TOEIC Test 3 Full 2025', 'Full', 100, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_question`
--

DROP TABLE IF EXISTS `exam_question`;
CREATE TABLE IF NOT EXISTS `exam_question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_answer` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_4` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passage_id` int(11) DEFAULT NULL,
  `listening_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`question_id`),
  KEY `exam_id` (`exam_id`) USING BTREE,
  KEY `Pass` (`passage_id`),
  KEY `FK_lis` (`listening_id`)
) ENGINE=InnoDB AUTO_INCREMENT=664 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exam_question`
--

INSERT INTO `exam_question` (`question_id`, `exam_id`, `content`, `correct_answer`, `option_1`, `option_2`, `option_3`, `option_4`, `passage_id`, `listening_id`) VALUES
(155, 1, 'Its…………into Brazil has given Darrow Textiles Ltd. an advantage over much of its competition.', 'A', 'expansion', 'process', 'creation', 'action', NULL, NULL),
(156, 1, 'Employees at NC media co., Ltd…………donate to local charities by hosting Fund-raising parties.', 'D', 'regularity', 'regularize', 'regularities', 'regularly', NULL, NULL),
(157, 1, 'From winning an Olympic gold medal in 2000 to becoming an NBA champion in 2008, Kevin Garnet has shown…………to be one of the most talented players.', 'D', 'he', 'him', 'himself', 'his', NULL, NULL),
(158, 1, 'An accurate…………of surveys is imperative to building a good understanding of customer needs.', 'D', 'opportunity', 'contract', 'destination', 'analysis', NULL, NULL),
(159, 1, 'QIB will work…………to maintain sustainable growth and expansion plans.', 'C', 'Persisted', 'Persistent', 'Persistently', 'Persistence', NULL, NULL),
(160, 1, 'The president has just realized that the launch of our new product must be postponed owing to…………conditions in the market.', 'B', 'unwilling', 'unfavorable', 'opposing', 'reluctant', NULL, NULL),
(161, 1, 'A letter…………by a copy of the press release was mailed to the public relations department yesterday.', 'C', 'accompanies', 'accompanying', 'accompanied', 'will accompany', NULL, NULL),
(162, 1, 'The announcement of John Stanton\'s retirement was not well received by most of the staff members, but Leslie, his long time friend and colleague, was extremely …….to hear that Mr Stanton will now be able to enjoy some leisure time.', 'D', 'happiest', 'happily', 'happier', 'happy', NULL, NULL),
(163, 1, 'Nevada Jobfind Inc. is planning to host a career fair for college graduates seeking…………in the healthcare sector.', 'B', 'employ', 'employment', 'employee', 'employing', NULL, NULL),
(164, 1, 'The manager has asked Mr. Lim to submit his final report on the sales of the new washing machine…………April 30 th .', 'D', 'with', 'toward', 'between', 'by', NULL, NULL),
(165, 1, 'Following the visit to your production facility in Hong Kong next week, we………….a comprehensive factory automation program to meet your company\'s needs.', 'A', 'will create', 'was created', 'having created', 'had been creating', NULL, NULL),
(166, 1, 'Any employers or contractors who are found to have…………safety laws will be subject to a heavy fine.', 'C', 'complied', 'observed', 'breached', 'adhered', NULL, NULL),
(167, 1, 'Mr. Tanaka decided to resign, because a significant drop in customer satisfaction has had an adverse impact on sales…………', 'D', 'grower', 'grow', 'grown', 'growth', NULL, NULL),
(168, 1, '………his appointment as our head of accounting services, Paul Robinson was working as a high-powered merchant banker in London.', 'B', 'Since', 'Prior to', 'Except', 'Because', NULL, NULL),
(169, 1, 'We believe that the popularity of …………products is the result of a combination of beauty and functionality.', 'C', 'Us', 'We', 'Our', 'Ours', NULL, NULL),
(170, 1, '………his falling out with his former employer, Mr. Lee still meets with some of his old co-workers from time to time.', 'D', 'Subsequently', 'However', 'Meanwhile', 'Despite', NULL, NULL),
(171, 1, 'Library users must remove all…………belongings when they leave the library for more than a half hour.', 'B', 'unlimited', 'personal', 'accurate', 'believable', NULL, NULL),
(172, 1, 'Personnel changes within the marketing department …………no surprise, as it completely failed to meet the target on the most recent project.', 'B', 'made of', 'came as', 'spoke of', 'came across', NULL, NULL),
(173, 1, '………anyone wish to access the information the status of his or her order, the password should be entered.', 'B', 'If', 'Should', 'Whether', 'As though', NULL, NULL),
(174, 1, 'The latest training…………contains tips on teaching a second language to international students.', 'B', 'method', 'guide', 'staff', 'role', NULL, NULL),
(175, 1, 'The more we spent with the sales team, the more…………we were with their innovative marketing skills.', 'D', 'impression', 'impress', 'impresses', 'impressed', NULL, NULL),
(176, 1, '………Mega Foods imports only one kind of cheese now, the company will be importing a total of five varieties by next year.', 'B', 'Until', 'Once', 'Unless', 'Although', NULL, NULL),
(177, 1, 'Anyone…………experiences complications with the new software is encouraged to bring this matter to Mr. Gruber\'s attention in room 210.', 'A', 'Who', 'Which', 'Whom', 'whose', NULL, NULL),
(178, 1, 'Fast………….in computer technology have made it possible for the public to access a second-to-none amount of news and information.', 'C', 'Inspections', 'Belongings', 'Advances', 'Commitments', NULL, NULL),
(179, 1, 'Whether it is………….to register for a student discount card depends on the needs of the individual.', 'A', 'necessary', 'necessarily', 'necessitate', 'necessity', NULL, NULL),
(180, 1, 'As space is limited, be sure to contact Bill in the personnel department a minimum of three days in advance to…………for a workshop.', 'C', 'approve', 'express', 'register', 'record', NULL, NULL),
(181, 1, 'Ms. Walters was…………to make a presentation on how to increase revenue when I entered the room.', 'D', 'nearly', 'off', 'close', 'about', NULL, NULL),
(182, 1, 'Considering her ability, dedication, and expertise, I am…………that Ms. Yoko will be the most suitable person for the position of marketing manager.', 'A', 'Confident', 'Obvious', 'Noticeable', 'Intelligent', NULL, NULL),
(183, 1, '………the workload is very high at the moment, all the team members are optimistic that they will be able to finish the required work on time.', 'A', 'Even though', 'According to', 'As if', 'In order for', NULL, NULL),
(184, 1, 'Because the store was………… located, it had a huge advantage in exposing its goods to the public, which had an impact on its increase in sales.', 'C', 'center', 'central', 'centrally', 'centered', NULL, NULL),
(185, 1, '………the city council has approved the urban renewal project, we need to recruit several new workers.', 'D', 'If so', 'Rather than', 'Owing to', 'Given that', NULL, NULL),
(186, 1, 'The technicians…………tested all air-conditioning units to ensure that the cooling system is running smoothly.', 'A', 'systematically', 'exceedingly', 'increasingly', 'lastly', NULL, NULL),
(187, 1, 'We have…………confidence in the product\'s ability to provide unrivaled protection in an exposed blast environment.', 'D', 'productive', 'eventual', 'informative', 'absolute', NULL, NULL),
(188, 1, 'The marketers make an…………of products that attract a wide variety of potential customers.', 'A', 'array', 'alleviation', 'origin', 'extension', NULL, NULL),
(189, 1, 'Newer branches can be opened worldwide…………we can properly translate our marketing goals.', 'A', 'as soon as', 'right away', 'promptly', 'in time for', NULL, NULL),
(190, 1, 'Despite the fact that the new…………was developed by MIN Communications, its parent company received all the credit for it.', 'A', 'technology', 'technologies', 'technological', 'technologists', NULL, NULL),
(191, 1, 'Greg O\'Leary has been leading research in our laboratories…………over eighteen years.', 'B', 'in', 'for', 'up', 'from', NULL, NULL),
(192, 1, 'Library and information science majors should be reminded of the seminar beginning…………at 6:00 p.m in room 212B.', 'A', 'promptly', 'prompts', 'prompter', 'prompted', NULL, NULL),
(193, 1, 'The meteorological agency recommended that tourists to the region be…………dressed for frigid conditions.', 'B', 'suitable', 'suitably', 'suitability', 'suitableness', NULL, NULL),
(194, 1, 'The letter from Ms. Win seems to have disappeared without a…………', 'C', 'whisper', 'peep', 'trace', 'flash', NULL, NULL),
(195, 1, 'Why is the LBA holding a meeting?', 'B', 'To review its bylaws', 'To revise its voting procedures', 'To inspire new members to join', 'To choose a new president', 1, NULL),
(196, 1, 'If Ms. LeChevre cannot attend the meeting, what should she do?', 'A', 'Complete a mail-in ballot', 'Send an apology letter to the president', 'Make a financial contribution to the LBA', 'Run for president', 1, NULL),
(197, 1, 'What is attached to the letter?', 'C', 'LBA\'s budget status', 'A annual calendar of events', 'Profiles of those running for president', 'A directory of small businesses', 1, NULL),
(198, 1, 'What can be inferred about Ms. LeChevre?', 'D', 'She wants to be president.', 'She works for the president.', 'She takes charge of counting the ballots.', 'She is a member of the LBA', 1, NULL),
(199, 1, 'What kind of place is SkyCity?', 'A', 'A restaurant', 'A ship', 'A museum', 'A theme park', 2, NULL),
(200, 1, 'When could you go with a party of 12 people?', 'B', 'February 2nd, without needing a reservation', 'June 24th, with a reservation', 'May 3rd, with a reservation', 'You cannot go with a group of 12 people', 2, NULL),
(201, 1, 'What time On Friday can you NOT reserve a table?', 'D', '10am', '2pm', '9pm', '10pm', 2, NULL),
(202, 1, 'Former Sendai Company CEO Ken Nakata spoke about _________ career experiences.', 'B', 'he', 'his', 'him', 'himself', 3, NULL),
(203, 1, 'Passengers who will be taking a _________ domestic flight should go to Terminal A.', 'D', 'connectivity', 'connects', 'connect', 'connecting', 3, NULL),
(204, 1, 'Fresh and _________ apple-cider donuts are available at Oakcrest Orchard’s retail shop for £6 per dozen.', 'C', 'eaten', 'open', 'tasty', 'free', 3, NULL),
(205, 1, 'Zahn Flooring has the widest selection of _________ in the United Kingdom.', 'B', 'paints', 'tiles', 'furniture', 'curtains', 3, NULL),
(206, 1, 'One responsibility of the IT department is to ensure that the company is using _________ software.', 'D', 'update', 'updating', 'updates', 'updated', 3, NULL),
(207, 1, 'It is wise to check a company’s dress code _________ visiting its head office.', 'D', 'so', 'how', 'like', 'before', 3, NULL),
(208, 1, 'Wexler Store’s management team expects that employees will _________ support any new hires.', 'A', 'enthusiastically', 'enthusiasm', 'enthusiastic', 'enthused', 3, NULL),
(209, 1, 'Wheel alignments and brake system _________ are part of our vehicle service plan.', 'D', 'inspects', 'inspector', 'inspected', 'inspections', 3, NULL),
(210, 1, 'Registration for the Marketing Coalition Conference is now open _________ September 30.', 'A', 'until', 'into', 'yet', 'while', 3, NULL),
(211, 1, 'Growth in the home entertainment industry has been _________ this quarter.', 'B', 'separate', 'limited', 'willing', 'assorted', 3, NULL),
(212, 1, 'Hawson Furniture will be making _________ on the east side of town on Thursday.', 'A', 'deliveries', 'delivered', 'deliver', 'deliverable', 3, NULL),
(213, 1, 'The Marlton City Council does not have the authority to _________ parking on city streets.', 'B', 'drive', 'prohibit', 'bother', 'travel', 3, NULL),
(214, 1, 'Project Earth Group is _________ for ways to reduce transport-related greenhouse gas emissions.', 'A', 'looking', 'seeing', 'driving', 'leaning', 3, NULL),
(215, 1, 'Our skilled tailors are happy to design a custom-made suit that fits your style and budget _________.', 'C', 'perfect', 'perfects', 'perfectly', 'perfection', 3, NULL),
(216, 1, 'Project manager Hannah Chung has proved to be very _________ with completing company projects.', 'D', 'helpfulness', 'help', 'helpfully', 'helpful', 3, NULL),
(217, 1, 'Lehua Vacation Club members will receive double points _________ the month of August at participating hotels.', 'C', 'onto', 'above', 'during', 'between', 3, NULL),
(218, 1, 'The costumes were not received _________ enough to be used in the first dress rehearsal.', 'D', 'far', 'very', 'almost', 'soon', 3, NULL),
(219, 1, 'As a former publicist for several renowned orchestras, Mr. Wu would excel in the role of event _________.', 'B', 'organized', 'organizer', 'organizes', 'organizational', 3, NULL),
(220, 1, 'The northbound lane on Davis Street will be _________ closed because of the city’s bridge reinforcement project.', 'A', 'temporarily', 'competitively', 'recently', 'collectively', 3, NULL),
(221, 1, 'Airline representatives must handle a wide range of passenger issues, _________ missed connections to lost luggage.', 'A', 'from', 'under', 'on', 'against', 3, NULL),
(222, 1, 'The meeting notes were _________ deleted, but Mr. Hahm was able to recreate them from memory.', 'D', 'accident', 'accidental', 'accidents', 'accidentally', 3, NULL),
(223, 1, 'The current issue of Farming Scene magazine predicts that the price of corn will rise 5 percent over the _________ year.', 'A', 'next', 'with', 'which', 'now', 3, NULL),
(224, 1, 'Anyone who still _________ to take the fire safety training should do so before the end of the month.', 'B', 'needing', 'needs', 'has needed', 'were needing', 3, NULL),
(225, 1, 'Emerging technologies have _________ begun to transform the shipping industry in ways that were once unimaginable.', 'A', 'already', 'exactly', 'hardly', 'closely', 3, NULL),
(226, 1, 'The company handbook outlines the high _________ that employees are expected to meet every day.', 'D', 'experts', 'accounts', 'recommendations', 'standards', 3, NULL),
(227, 1, 'Because _________ of the board members have scheduling conflicts, the board meeting will be moved to a date when all can attend.', 'D', 'any', 'everybody', 'those', 'some', 3, NULL),
(228, 1, 'The project _________ the collaboration of several teams across the company.', 'C', 'passed', 'decided', 'required', 'performed', 3, NULL),
(229, 1, 'We cannot send the store’s coupon booklet to the printers until it _________ by Ms. Jeon.', 'C', 'is approving', 'approves', 'has been approved', 'will be approved', 3, NULL),
(230, 1, '_________ the closure of Verdigold Transport Services, we are looking for a new shipping company.', 'C', 'In spite of', 'Just as', 'In light of', 'According to', 3, NULL),
(231, 1, 'The _________ information provided by Uniss Bank’s brochure helps applicants understand the terms of their loans.', 'B', 'arbitrary', 'supplemental', 'superfluous', 'potential', 3, NULL),
(232, 2, 'What is being advertised?', 'C', 'A vacation rental', 'A new hotel', 'An event space', 'A summer camp', 4, NULL),
(233, 2, 'What will be offered on October 10?', 'D', 'A discounted reservation rate', 'A special concert', 'A famous recipe book', 'A class by a famous chef', 4, NULL),
(234, 2, 'Before operating your handheld device, please __________ the enclosed cable to charge it.', 'C', 'plan', 'remain', 'use', 'finish', NULL, NULL),
(235, 2, 'Safile\'s new external hard drive can __________ store up to one terabyte of data.', 'C', 'secure', 'security', 'securely', 'secured', NULL, NULL),
(236, 2, 'Mr. Peterson will travel __________ the Tokyo office for the annual meeting.', 'A', 'to', 'through', 'in', 'over', NULL, NULL),
(237, 2, 'Yong-Soc Cosmetics will not charge for items on back order until __________ have left our warehouse.', 'B', 'them', 'they', 'themselves', 'their', NULL, NULL),
(238, 2, 'Our premium day tour takes visitors to historic sites __________ the Aprico River.', 'D', 'onto', 'since', 'inside', 'along', NULL, NULL),
(239, 2, 'Eighty percent of drivers surveyed said they would consider buying a vehicle that runs on __________.', 'A', 'electricity', 'electrically', 'electricians', 'electrify', NULL, NULL),
(240, 2, 'Xinzhe Zu has __________ Petrin Engineering as the vice president of operations.', 'C', 'attached', 'resigned', 'joined', 'combined', NULL, NULL),
(241, 2, 'Next month, Barder House Books will be holding __________ third author\'s hour in Cleveland.', 'D', 'it', 'itself', 'its own', 'its', NULL, NULL),
(242, 2, 'Chester’s Tiles __________ expanded to a second location in Turnington.', 'C', 'severely', 'usually', 'recently', 'exactly', NULL, NULL),
(243, 2, 'Tabrino\'s has __________ increased the number of almonds in the Nut Medley snack pack.', 'D', 'significant', 'significance', 'signifies', 'significantly', NULL, NULL),
(244, 2, '__________ she travels, Jacintha Flores collects samples of local fabrics and patterns.', 'A', 'Wherever', 'in addition to', 'Either', 'in contrast to', NULL, NULL),
(245, 2, 'Most picture __________ at Glowing Photo Lab go on sale at 3:00 PM. today.', 'D', 'framer', 'framing', 'framed', 'frames', NULL, NULL),
(246, 2, 'All students in the business management class hold __________ college degrees.', 'C', 'late', 'developed', 'advanced', 'elated', NULL, NULL),
(247, 2, 'We hired Noah Wan of Shengyao Accounting Ltd, __________ our company\'s financial assets.', 'A', 'to evaluate', 'to be evaluated', 'will be evaluated', 'evaluate', NULL, NULL),
(248, 2, 'Ms. Charisse is taking on a new account __________ she finishes the Morrison project.', 'C', 'with', 'going', 'after', 'between', NULL, NULL),
(249, 2, 'Cormet Motors\' profits are __________ this year than last year.', 'A', 'higher', 'high', 'highly', 'highest', NULL, NULL),
(250, 2, 'In its __________ advertising campaign. Jaymor Tools demonstrates how reliable its products are.', 'A', 'current', 'relative', 'spacious', 'collected', NULL, NULL),
(251, 2, 'Remember to submit receipts for reimbursement __________ returning from a business trip.', 'B', 'such as', 'when', 'then', 'within', NULL, NULL),
(252, 2, 'Patrons will be able to access Westside Library\'s __________ acquired collection of books on Tuesday.', 'B', 'instantly', 'newly', 'early', 'naturally', NULL, NULL),
(253, 2, 'Please __________ any questions about time sheets to Tabitha Jones in the payroll department.', 'D', 'direction', 'directive', 'directed', 'direct', NULL, NULL),
(254, 2, 'Before signing a delivery __________, be sure to double-check that all the items ordered are in the shipment.', 'C', 'decision', 'announcement', 'receipt', 'limit', NULL, NULL),
(255, 2, 'Funds have been added to the budget for expenses __________ with the new building.', 'A', 'associated', 'association', 'associate', 'associates', NULL, NULL),
(256, 2, 'Ms. Bernard __________ that a deadline was approaching. so she requested some assistance.', 'A', 'noticed', 'obscured', 'withdrew', 'appeared', NULL, NULL),
(257, 2, 'Mr. Moscowitz is __________ that Dr. Tanaka will agree to present the keynote speech at this year\'s conference.', 'C', 'hopes', 'hoped', 'hopeful', 'hopefully', NULL, NULL),
(258, 2, 'Two Australian companies are developing new smartphones, but it is unclear __________ phone will become available first.', 'B', 'if', 'which', 'before', 'because', NULL, NULL),
(259, 2, 'Corners Gym offers its members a free lesson in how to use __________ property.', 'B', 'weighs', 'weights', 'weighty', 'weighed', NULL, NULL),
(260, 2, '__________ the rules, overnight parking is not permitted at the clubhouse facility.', 'D', 'Prior to', 'Except for', 'Instead of', 'According to', NULL, NULL),
(261, 2, 'Once everyone __________, we can begin the conference call.', 'D', 'arrived', 'is arriving', 'to arrive', 'has arrived', NULL, NULL),
(262, 2, 'Each summer a motivational video that highlights the past year\'s __________ is shown to all company employees.', 'B', 'preferences', 'accomplishments', 'communications', 'uncertainties', NULL, NULL),
(263, 2, 'Employees who wish to attend the retirement dinner __________ Ms. Howell\'s 30 years of service should contact Mr. Lee.', 'B', 'honor', 'to honor', 'will honor', 'will be honored', NULL, NULL),
(264, 2, '139.', 'B', 'agree', 'vary', 'wait', 'decline', 5, NULL),
(265, 2, '140.', 'C', 'receiving', 'having received', 'received', 'will be received', 5, NULL),
(266, 2, '141.', 'D', 'The updated price list will be available on March 20.', 'We apologize for this inconvenience.', 'Your orders will be shipped after April 17.', 'We are increasing prices because of rising costs.', 5, NULL),
(267, 2, '142.', 'A', 'exceptionally', 'exception', 'exceptional', 'exceptionalism', 5, NULL),
(268, 2, '143.', 'C', 'patients', 'students', 'customers', 'teammates', 6, NULL),
(269, 2, '144.', 'D', 'If you need more time, please let me know.', 'Unfortunately, I do not have adequate shelf space at this time.', 'I would like to show you some of my own designs.', 'The reasonable prices also make your pieces a great value.', 6, NULL),
(270, 2, '145.', 'A', 'include', 'double', 'repeat', 'insure', 6, NULL),
(271, 2, '146.', 'B', 'us', 'you', 'we', 'these', 6, NULL),
(272, 2, 'When filling out the order form, please ____________ your address clearly to prevent delays.', 'B', 'fix', 'write', 'send', 'direct', NULL, NULL),
(275, 2, 'The free clinic was founded by a group of doctors to give ____________ for various medical conditions.', 'A', 'treatment', 'treat', 'treated', 'treating', NULL, NULL),
(278, 2, 'The figures that accompany the financial statement should be ____________ to the spending %\' category.', 'D', 'relevance', 'relevantly', 'more relevantly', 'relevant', NULL, NULL),
(279, 2, 'The building owner purchased the property ____________ three months ago, but she has already spent a great deal of money on renovations.', 'B', 'yet', 'just', 'few', 'still', NULL, NULL),
(280, 2, 'We would like to discuss this problem honestly and ____________ at the next staff meeting.', 'C', 'rarely', 'tiredly', 'openly', 'highly', NULL, NULL),
(281, 2, 'The store\'s manager plans to put the new merchandise on display ____________ to promote the line of fall fashions.', 'A', 'soon', 'very', 'that', 'still', NULL, NULL),
(282, 2, 'During the peak season, it is ____________ to hire additional workers for the weekend shifts.', 'C', 'necessitate', 'necessarily', 'necessary', 'necessity', NULL, NULL),
(283, 2, 'Now that the insulation has been replaced, the building is much more energy-efficient.', 'A', 'Now', 'For', 'As', 'Though', NULL, NULL),
(284, 2, 'Mr. Sims needs a more ____________ vehicle for commuting from his suburban home to his office downtown.', 'B', 'expressive', 'reliable', 'partial', 'extreme', NULL, NULL),
(285, 2, 'The company ____________ lowered its prices to outsell its competitors and attract more customers.', 'B', 'strategy', 'strategically', 'strategies', 'strategic', NULL, NULL),
(286, 2, 'Before Mr. Williams addressed the audience, he showed a brief video about the engine he had designed.', 'C', 'Then', 'So that', 'Before', 'Whereas', NULL, NULL),
(287, 2, 'For optimal safety on the road, avoid ____________ the view of the rear window and side-view mirrors.', 'D', 'obstructs', 'obstructed', 'obstruction', 'obstructing', NULL, NULL),
(288, 2, 'Having proper ventilation throughout the building is ___________ for protecting the health and well-being of the workers.', 'C', 'cooperative', 'visible', 'essential', 'alternative', NULL, NULL),
(289, 2, 'The fact that sales of junk food have been steadily declining indicates that consumers are becoming more health-conscious.', 'B', 'In addition to', 'The fact that', 'As long as', 'In keeping with', NULL, NULL),
(290, 2, 'The sprinklers for the lawn\'s irrigation system are ___________ controlled.', 'A', 'mechanically', 'mechanic', 'mechanism', 'mechanical', NULL, NULL),
(291, 2, 'The library staff posted signs to ___________ patrons of the upcoming closure for renovations.', 'A', 'notify', 'agree', 'generate', 'perform', NULL, NULL),
(292, 2, 'Mr. Ross, ___________ is repainting the interior of the lobby, was recommended by a friend of the building manager.', 'C', 'himself', 'he', 'who', 'which', NULL, NULL),
(293, 2, 'The guidelines for the monthly publication are ___________ revised to adapt to the changing readers.', 'C', 'courteously', 'initially', 'periodically', 'physically', NULL, NULL),
(294, 2, 'In spite of an ankle injury, the baseball player participated in the last game of the season.', 'A', 'In spite of', 'Even if', 'Whether', 'Given that', NULL, NULL),
(295, 2, 'The governmental department used to provide financial aid, but now it offers ___________ services only.', 'A', 'legal', 'legalize', 'legally', 'legalizes', NULL, NULL),
(296, 2, 'At the guest\'s ___________ , an extra set of towels and complimentary soaps were brought to the room.', 'C', 'quote', 'graduation', 'request', 'dispute', NULL, NULL),
(297, 2, 'The upscale boutique Jane\'s Closet is known for selling the most stylish ___________ for young professionals.', 'D', 'accessorized', 'accessorize', 'accessorizes', 'accessories', NULL, NULL),
(298, 2, 'The company started to recognize the increasing ___________ of using resources responsibly.', 'C', 'more important', 'importantly', 'importance', 'important', NULL, NULL),
(299, 2, 'After restructuring several departments within the company, the majority of the problems with miscommunication have disappeared.', 'A', 'After', 'Until', 'Below', 'Like', NULL, NULL),
(300, 2, 'The riskiest ___________ of the development of new medications are the trials with human subjects.', 'D', 'proceeds', 'perspectives', 'installments', 'stages', NULL, NULL),
(301, 2, 'Anyone seeking a position at Tulare Designs must submit a portfolio of previous work.', 'A', 'Anyone', 'Whenever', 'Other', 'Fewer', NULL, NULL),
(302, 2, '', 'A', 'Throughout the trial, you pay nothing and sign no contract.', 'Weight-lifting classes are not currently available.', 'A cash deposit is required when you sign up for membership.', 'All questions should be e-mailed to customerservice@gsgym.com.', 7, NULL),
(303, 2, '', 'D', 'not even', 'almost', 'over', 'less than', 7, NULL),
(304, 2, '', 'B', 'justly', 'regularly', 'evenly', 'simply', 7, NULL),
(305, 2, '', 'C', 'extend', 'renew', 'cancel', 'initiate', 7, NULL),
(306, 2, '', 'C', 'cost', 'delay', 'decision', 'forecast', 8, NULL),
(307, 2, '', 'D', 'Such a figure is unprecedented in the company\'s history.', 'Moreover, Ms. Seiler holds an advanced degree in economics.', 'Pecans are high in vitamins and minerals.', 'Still, MKZ shares have been profitable in recent years.', 8, NULL),
(308, 2, '', 'B', 'on', 'for', 'in', 'by', 8, NULL),
(309, 2, '', 'D', 'farming', 'farmer', 'farmed', 'farm', 8, NULL),
(314, 2, 'York Development Corporation marked the ______ of the Ford Road office complex with a ribbon-cutting ceremony.', 'B', 'opens', 'opening', 'opened', 'openly', NULL, NULL),
(315, 2, 'Staff at the Bismarck Hotel were ______ helpful to us during our stay.', 'A', 'quite', 'enough', 'far', 'early', NULL, NULL),
(316, 2, 'Ms. Luo will explain some possible consequences of the ______ merger with the Wilson-Peek Corporation.', 'A', 'proposed', 'proposal', 'proposition', 'proposing', NULL, NULL),
(317, 2, 'The Springdale supermarket survey ______ will be released a week after they are evaluated.', 'C', 'events', 'stores', 'results', 'coupons', NULL, NULL),
(318, 2, 'The new printer operates more ______ than the previous model did.', 'D', 'quickest', 'quickness', 'quick', 'quickly', NULL, NULL),
(319, 2, 'Here at Vanguard Buying Club, ______ help members find quality merchandise at the lowest possible prices.', 'C', 'us', 'our', 'we', 'ourselves', NULL, NULL),
(320, 2, 'Management announced that all salespeople would be receiving a bonus this year, ______ in time for summer vacations.', 'A', 'just', 'as', 'only', 'by', NULL, NULL),
(321, 2, 'According to Florida Digital Designer Magazine, many graphic designers do not consider ______ to be traditional artists.', 'C', 'it', 'their', 'themselves', 'itself', NULL, NULL),
(322, 2, 'A wooden bridge crossing the wading pond ______ to the hotel\'s nine-hole golf course.', 'B', 'prepares', 'leads', 'presents', 'takes', NULL, NULL),
(323, 2, 'A special sale on stationery ______ on the Write Things Web site yesterday.', 'A', 'was announced', 'announced', 'was announcing', 'to announce', NULL, NULL),
(324, 2, 'All produce transported by Gocargo Trucking is refrigerated ______ upon pickup to prevent spoilage.', 'B', 'lately', 'promptly', 'potentially', 'clearly', NULL, NULL),
(325, 2, 'The Ferrera Museum plans to exhibit a collection of Lucia Almeida’s most ______ sculptures.', 'A', 'innovative', 'innovation', 'innovatively', 'innovate', NULL, NULL),
(326, 2, 'The bank’s cashier windows are open daily from 8:00 A.M. to 4:00 P.M. ______ on Sundays.', 'A', 'except', 'until', 'nor', 'yet', NULL, NULL),
(327, 2, 'Inventory control and warehousing strategies ______ within the responsibilities of the supply chain manager.', 'D', 'have', 'cover', 'mark', 'fall', NULL, NULL),
(328, 2, 'Of all the truck models available today, it can be difficult to figure out ______ would best suit your company’s needs.', 'C', 'when', 'why', 'which', 'where', NULL, NULL),
(329, 2, 'CEO Yoshiro Kasai has expressed complete faith in Fairway Maritime’s ______ to deliver the product on time.', 'D', 'belief', 'measure', 'problem', 'ability', NULL, NULL),
(330, 2, 'At Derwin Securities, trainees alternate ______ attending information sessions and working closely with assigned mentors.', 'C', 'along', 'against', 'between', 'near', NULL, NULL),
(331, 2, 'Company Vice President Astrid Barretto had no ______ to being considered for the position of CEO.', 'D', 'objected', 'objecting', 'objects', 'objection', NULL, NULL),
(332, 2, 'Belinda McKay fans who are ______ to the author’s formal writing style will be surprised by her latest biography.', 'D', 'fortunate', 'readable', 'comparable', 'accustomed', NULL, NULL),
(333, 2, 'The Southeast Asia Business Convention will feature ______ known and respected leaders from countries across the region.', 'C', 'widen', 'wider', 'widely', 'wide', NULL, NULL),
(334, 2, '______ the high cost of fuel, customers are buying smaller, more efficient cars.', 'D', 'Together with', 'Instead of', 'As well as', 'Because of', NULL, NULL),
(335, 2, 'Over the past ten years, Bellworth Medical Clinic ______ Atlan Protection officers for all security needs.', 'C', 'is hiring', 'were hiring', 'has hired', 'was hired', NULL, NULL),
(336, 2, 'What is the purpose of the article?', 'B', 'To promote a technology show', 'To introduce a product', 'To interview smartphone users', 'To announce a recall of a device', 9, NULL),
(337, 2, 'How much do the Gorman Pro Phone 4 wireless headphones cost?', 'C', '£39', '£59', '£79', '£100', 9, NULL),
(338, 2, 'What does the Pro Phone 4 have in common with prior models?', 'D', 'The screen size', 'The camera resolution', 'The price', 'The charger', 9, NULL),
(339, 2, 'In which of the positions marked [1], [2], [3], and [4] does the following sentence best belong? \"These upgrades do come at a cost.\"', 'C', '[1]', '[2]', '[3]', '[4]', 9, NULL),
(340, 1, '139.', 'A', 'offering', 'accepting', 'discussing', 'advertising', 10, NULL),
(341, 1, '140.', 'D', 'accompany', 'did accompany', 'accompanies', 'will accompany', 10, NULL),
(342, 1, '141.', 'B', 'too', 'also', 'as well as', 'additionally', 10, NULL),
(343, 1, '142.', 'D', 'Please sign all the documents.', 'I will provide you with a replacement.', 'Construction will be completed next year.', 'You can download one from our Web site.', 10, NULL),
(344, 1, 'What is suggested about the company Ms. Chichester works for?', 'A', 'It currently has no large-sized shirts in stock.', 'It has filled an order for Mr. Gerew before.', 'It offers discounts on large orders.', 'It is open every evening.', 11, NULL),
(345, 1, 'Why is Mr. Gerew ordering new shirts?', 'B', 'Additional staff members have been hired.', 'More were sold than had been anticipated.', 'The company’s logo has been changed.', 'The style currently in use has become outdated.', 11, NULL),
(346, 1, 'At 1:38 P.M., what does Mr. Gerew mean when he writes, “I guess it can’t be helped”?', 'A', 'He will pay a $75 rush-order fee.', 'He will ask his assistant to help him.', 'He will meet Ms. Chichester at 1:00 P.M.', 'He will select the standard production option.', 11, NULL),
(347, 1, 'What will Mr. Gerew likely do next?', 'A', 'Provide payment information to Ms. Chichester', 'Schedule a meeting with Ms. Chichester', 'Send an e-mail to Ms. Chichester', 'Fix Ms. Chichester’s computer', 11, NULL),
(348, 1, 'The regional manager will arrive tomorrow, so please ensure that all ----------------- documents are ready.', 'B', 'she', 'her', 'hers', 'herself', NULL, NULL),
(349, 1, 'The historic Waldridge Building was constructed nearly 200 years -----------------.', 'C', 'away', 'enough', 'ago', 'still', NULL, NULL),
(350, 1, 'Consumers ------------- enthusiastically to the new colors developed by Sanwell Paint.', 'D', 'responding', 'response', 'responsively', 'responded', NULL, NULL),
(351, 1, 'The ---------------------------files contain your employment contract and information about our company.', 'B', 'directed', 'attached', 'interested', 'connected', NULL, NULL),
(352, 1, 'Please submit each reimbursement request ----------------- according to its category, as outlined in last month’s memo.', 'A', 'separately', 'separateness', 'separates', 'separate', NULL, NULL),
(353, 1, 'Customers can wait in the reception area ------------ our mechanics complete the car repairs.', 'C', 'whether', 'except', 'while', 'during', NULL, NULL),
(354, 1, 'No one without a pass will be granted ---------------- to the conference.', 'A', 'admission', 'is admitting', 'admitted', 'to admit', NULL, NULL),
(355, 1, 'To receive an electronic reminder when payment is due, set up an online account ---------------- Albright Bank.', 'D', 'of', 'about', 'over', 'with', NULL, NULL),
(356, 1, 'The registration fee is ---------------- refundable up to two weeks prior to the conference date.', 'C', 'fullest', 'fuller', 'fully', 'full', NULL, NULL),
(357, 1, 'All identifying information has been ------------------ from this letter of complaint so that it can be used for training purposes.', 'C', 'produced', 'extended', 'removed', 'resolved', NULL, NULL),
(358, 1, '----------------- this time next year, Larkview Technology will have acquired two new subsidiaries.', 'B', 'To', 'By', 'Quite', 'Begin', NULL, NULL),
(359, 1, 'Table reservations for ------------------ greater than ten must be made at least one day in advance.', 'D', 'plates', 'meals', 'sizes', 'parties', NULL, NULL),
(360, 1, 'Because of --------------- weather conditions, tonight\'s concert in Harbin Park has been canceled.', 'A', 'worsening', 'worsens', 'worsen', 'worst', NULL, NULL),
(361, 1, 'Ms. Al-Omani will rely ------------------------- team leaders to develop employee incentive programs.', 'D', 'onto', 'into', 'within', 'upon', NULL, NULL),
(362, 1, 'Survey ------------------------- analyze the layout of a land area above and below ground level.', 'A', 'technicians', 'technically', 'technical', 'technicality', NULL, NULL),
(463, 4, 'Why is the woman calling?', 'C', 'To make an appointment', 'To rent a car', 'To ask about a fee', 'To apply for a position', NULL, 2),
(464, 4, 'According to the man, what has recently changed?', 'C', 'Office hours', 'Job requirements', 'A computer system', 'A company policy', NULL, 2),
(465, 4, 'What does the man agree to do?', 'A', 'Waive a fee', 'Reschedule a meeting', 'Sign a contract', 'Repair a vehicle', NULL, 2),
(466, 4, 'What is the topic of the conversation?', 'B', 'Health', 'Traffic', 'Sports', 'Finance', NULL, 2),
(467, 4, 'What caused a problem?', 'D', 'A staffing change', 'A rainstorm', 'A typographical error', 'A road closure', NULL, 2),
(468, 4, 'What will the listeners hear next?', 'C', 'A commercial', 'A song', 'A weather report', 'A reading from a book', NULL, 2),
(469, 4, 'What does the woman notify the man about?', 'C', 'She is unable to meet a deadline.', 'She needs a replacement laptop.', 'She cannot attend a business trip.', 'She is planning to give a speech.', NULL, 2),
(470, 4, 'According to the woman, what recently happened in her department?', 'D', 'A corporate policy was updated.', 'A supply order was mishandled.', 'Client contracts were renewed.', 'New employees were hired.', NULL, 2),
(471, 4, 'What does the man say he will do next?', 'A', 'Speak with a colleague', 'Conduct an interview', 'Calculate a budget', 'Draft a travel itinerary', NULL, 2),
(472, 4, 'What does the man want to do?', 'D', 'Purchase an area map', 'See an event schedule', 'Cancel a hotel reservation', 'Book a bus tour', NULL, 2),
(473, 4, 'What is the man asked to choose?', 'B', 'When to arrive', 'What to visit', 'How to pay', 'What to eat', NULL, 2),
(474, 4, 'What does the woman suggest doing?', 'D', 'Wearing a jacket', 'Using a credit card', 'Bringing a camera', 'Looking for a coupon', NULL, 2),
(475, 4, 'What does the man offer to do?', 'C', 'Meet in the lobby', 'Contact a receptionist', 'Carry some files', 'Delay a meeting', NULL, 2),
(476, 4, 'According to the man, what happened last week?', 'C', 'An office door would not lock.', 'A sink was installed incorrectly.', 'An elevator stopped working.', 'A document was lost.', NULL, 2),
(477, 4, 'Why does the woman say, “a piece of hardware had to be custom made”?', 'B', 'To justify a price', 'To explain a delay', 'To illustrate a product\'s age', 'To express regret for a purchase', NULL, 2),
(478, 4, 'What product are the speakers discussing?', 'C', 'Electronics', 'Office furniture', 'Calendars', 'Clothing', NULL, 2),
(479, 4, 'What does Donna suggest?', 'C', 'Hiring additional staff', 'Revising a budget', 'Posting some photos online', 'Reducing prices', NULL, 2),
(480, 4, 'What does the man propose?', 'B', 'Postponing a decision', 'Conducting a survey', 'Developing new products', 'Opening another location', NULL, 2),
(481, 4, 'Who most likely is the man?', 'A', 'A manager', 'A consultant', 'A client', 'A trainee', NULL, 2),
(482, 4, 'What does the woman ask the man for?', 'D', 'Some feedback', 'Some assistance', 'Some references', 'Some dates', NULL, 2),
(483, 4, 'What will the man receive?', 'D', 'Extra time off', 'A promotion', 'Bonus pay', 'An award', NULL, 2),
(484, 4, 'What type of product is being discussed?', 'D', 'A musical instrument', 'A kitchen appliance', 'A power tool', 'A tablet computer', NULL, 2),
(485, 4, 'Which product feature is the man most proud of?', 'A', 'The battery life', 'The color selection', 'The sound quality', 'The size', NULL, 2),
(486, 4, 'Why does the man say, “my favorite singer is performing that night”?', 'C', 'To request a schedule change', 'To explain a late arrival', 'To decline an invitation', 'To recommend a musician', NULL, 2),
(487, 4, 'What type of event is being planned?', 'B', 'A trade show', 'An awards ceremony', 'A film festival', 'A wedding', NULL, 2),
(488, 4, 'What does the man ask about?', 'C', 'Accommodations', 'Entertainment', 'Meal options', 'Outdoor seating', NULL, 2),
(489, 4, 'What does the hotel offer for free?', 'D', 'Meals', 'Internet access', 'Transportation', 'Parking', NULL, 2),
(490, 4, 'What problem does the man mention?', 'B', 'His car is out of fuel.', 'His phone battery is empty.', 'He is late for an appointment.', 'He forgot his wallet.', NULL, 2),
(491, 4, 'Where are the speakers?', 'B', 'At a train station', 'At an electronics repair shop', 'At a furniture store', 'At a coffee shop', NULL, 2),
(492, 4, 'What does the woman suggest the man do?', 'A', 'Check a Web site', 'Call a taxi', 'Return at a later time', 'Go to the library', NULL, 2),
(493, 4, 'What is the man having trouble with?', 'C', 'Conducting a test', 'Preparing a bill', 'Contacting a patient', 'Shipping an order', NULL, 2),
(494, 4, 'Look at the graphic. Which code should the man use?', 'C', '01B', '019', '020', '021', NULL, 2),
(495, 4, 'What does the woman say will happen soon?', 'C', 'Some patients will be transferred to another doctor.', 'Some employees will join a medical practice.', 'A list will be available electronically.', 'A doctor will begin a medical procedure.', NULL, 2),
(496, 4, 'What does the woman say they will need to do?', 'D', 'Rent storage space', 'Increase production', 'Organize a fashion show', 'Update some equipment', NULL, 2),
(497, 4, 'What does the man suggest?', 'B', 'Conferring with a client', 'Contacting another department', 'Photographing some designs', 'Changing suppliers', NULL, 2),
(498, 4, 'Look at the graphic. Which section of the label will the men need to revise?', 'C', 'The logo', 'The material', 'The care instructions', 'The country of origin', NULL, 2),
(499, 4, 'What are the speakers mainly discussing?', 'C', 'A job interview', 'A company celebration', 'An office relocation', 'A landscaping project', NULL, 2),
(500, 4, 'Look at the graphic. Which building is Silverby Industries located in?', 'B', 'Building 1', 'Building 2', 'Building 3', 'Building 4', NULL, 2),
(501, 4, 'What does the woman tell the man about parking?', 'C', 'He should park in a visitor\'s space.', 'He will have to pay at a meter.', 'A parking pass is required.', 'The parking area fills up quickly.', NULL, 2),
(502, 4, 'What type of business is being advertised?', 'B', 'A farmers market', 'A fitness center', 'A medical clinic', 'A sporting goods store', NULL, 1),
(503, 4, 'What will the listeners be able to do starting in April?', 'C', 'Use multiple locations', 'Try free samples', 'Meet with a nutritionist', 'Enter a contest', NULL, 1),
(504, 4, 'Why does the speaker invite the listeners to visit a Web site?', 'D', 'To write a review', 'To register for a class', 'To check a policy', 'To look at a map', NULL, 1),
(505, 4, 'Why does the speaker thank the listeners?', 'C', 'For submitting design ideas', 'For training new employees', 'For working overtime', 'For earning a certification', NULL, 1),
(506, 4, 'According to the speaker. what is scheduled for next month?', 'D', 'A retirement celebration', 'A trade show', 'A factory tour', 'A store opening', NULL, 1),
(507, 4, 'What does the speaker imply when she says, “it’s a large space\"?', 'A', 'There is room to display new merchandise.', 'High attendance is anticipated.', 'Avenue is too expensive.', 'There is not enough staff for an event.', NULL, 1),
(508, 4, 'According to the speaker. what is special about the restaurant?', 'C', 'It has private outdoor seating.', 'It has been recently renovated.', 'It has a vegetable garden.', 'It has weekly cooking classes.', NULL, 1),
(509, 4, 'Who is Natasha?', 'D', 'A business owner', 'An interior decorator', 'An event organizer', 'A food writer', NULL, 1),
(510, 4, 'Why does the speaker say, “I eat it all the time”?', 'B', 'He wants to eat something different.', 'He is recommending a dish.', 'He knows the ingredients.', 'He understands a dish is popular.', NULL, 1),
(511, 4, 'Where is the announcement being made?', 'C', 'On a bus', 'On a ferry boat', 'On a train', 'On an airplane', NULL, 1),
(512, 4, 'What problem does the speaker mention?', 'D', 'There is no more room for large bags.', 'Too many tickets have been sold.', 'Weather conditions have changed.', 'A piece of equipment is being repaired.', NULL, 1),
(513, 4, 'According to the speaker, why should the listeners talk with a staff member?', 'D', 'To receive a voucher', 'To reserve a seat', 'To buy some food', 'To get free headphones', NULL, 1),
(514, 4, 'Who is the speaker?', 'D', 'A repair person', 'A store clerk', 'A factory worker', 'A truck driver', NULL, 1),
(515, 4, 'What does the company sell?', 'D', 'Household furniture', 'Kitchen appliances', 'Packaged foods', 'Construction equipment', NULL, 1),
(516, 4, 'What does the speaker imply when she says, “all I see are houses”?', 'B', 'She is concerned about some regulations.', 'She thinks a mistake has been made.', 'A loan application has been completed.', 'A development plan cannot be approved.', NULL, 1),
(517, 4, 'What is the talk mainly about?', 'D', 'A mobile phone model', 'An office security system', 'High-speed Internet service', 'Business scheduling software', NULL, 1),
(518, 4, 'Why did the company choose the product?', 'A', 'It makes arranging meetings easy.', 'It is reasonably priced.', 'It has good security features.', 'It has received positive reviews.', NULL, 1),
(519, 4, 'What does the speaker say is offered with the product?', 'D', 'An annual upgrade', 'A money-back guarantee', 'A mobile phone application', 'A customer-service help line', NULL, 1),
(520, 4, 'What does the speaker say has recently been announced?', 'C', 'An increase in funding', 'A factory opening', 'A new venue for an event', 'A change in regulations', NULL, 1),
(521, 4, 'According to the speaker. why do some people dislike a construction project?', 'D', 'Because it caused a power outage', 'Because it costs too much', 'Because roads have been closed', 'Because of the loud noise', NULL, 1),
(522, 4, 'What will the speaker do next?', 'C', 'Introduce an advertiser', 'Attend a press conference', 'Interview some people', 'End a broadcast', NULL, 1),
(523, 4, 'What does the speaker thank the listeners for?', 'C', 'Reorganizing some files', 'Cleaning a work area', 'Working on a Saturday', 'Attending a training', NULL, 1),
(524, 4, 'In which division do the listeners most likely work?', 'A', 'Shipping and Receiving', 'Maintenance', 'Sales and Marketing', 'Accounting', NULL, 1),
(525, 4, 'What does the speaker say he will provide?', 'C', 'A building name', 'Group numbers', 'Shift schedules', 'A temporary password', NULL, 1),
(526, 4, 'What event is being described?', 'C', 'A sports competition', 'A government ceremony', 'A music festival', 'A cooking contest', NULL, 1),
(527, 4, 'According to the speaker. what can the listeners find on a Web site?', 'B', 'A city map', 'A list of vendors', 'A demonstration video', 'An entry form', NULL, 1),
(528, 4, 'Look at the graphic. Which day is the event being held?', 'A', 'Saturday', 'Sunday', 'Monday', 'Tuesday', NULL, 1),
(529, 4, 'What is the purpose of the call?', 'C', 'To confirm a deadline', 'To explain a company policy', 'To make a job offer', 'To discuss a new product', NULL, 1),
(530, 4, 'Look at the graphic. Who is the speaker calling?', 'D', 'Carla Wynn', 'JaeI-lo Kim', 'Kaori Aoki', 'Alex Lehmann', NULL, 1),
(531, 4, 'What does the speaker ask the listener to do?', 'C', 'Check a catalog', 'Send fee information', 'Submit a travel itinerary', 'Update a conference schedule', NULL, 1),
(532, 4, 'What does the company most likely produce?', 'C', 'Print advertisements', 'Television shows', 'Computer parts', 'Musical instruments', NULL, 3),
(533, 4, 'What department will the man work in?', 'C', 'Accounting', 'Legal', 'Human resources', 'Security', NULL, 3),
(534, 4, 'What does the man like about his work area?', 'B', 'It is conveniently located.', 'It has a good view.', 'It is quiet.', 'It is nicely decorated.', NULL, 3),
(535, 4, 'What is the conversation mainly about?', 'A', 'A room reservation', 'A canceled event', 'A restaurant recommendation', 'A misplaced item', NULL, 3),
(536, 4, 'What does the men need to provide?', 'C', 'A security deposit', 'A revised schedule', 'A form of identification', 'A business address', NULL, 3),
(537, 4, 'What do the visitors ask for?', 'D', 'A refund', 'Better lighting', 'Menu options', 'More chairs', NULL, 3),
(538, 4, 'Where does the conversation most likely take place?', 'B', 'At a shopping mall', 'At a theater', 'In a sports stadium', 'On a train', NULL, 3),
(539, 4, 'Why does the woman say, \"The football championship is this afternoon\"?', 'C', 'To extend an invitation', 'To offer encouragement', 'To give an explanation', 'To request a schedule change', NULL, 3),
(540, 4, 'What does the man say he needs to purchase?', 'A', 'Tickets', 'Clothes', 'Food', 'Furniture', NULL, 3),
(541, 4, 'What problem does the man mention?', 'D', 'Some products are damaged.', 'Some equipment is out of stock.', 'A vehicle has broken down.', 'A delivery error has occurred.', NULL, 3),
(542, 4, 'What does the woman say is planned for Friday?', 'A', 'A product launch', 'An inspection', 'A cooking class', 'An interview', NULL, 3),
(543, 4, 'What does the men say he will do?', 'B', 'Transfer 8 call', 'Issue a refund', 'Provide a warranty', 'Visit a business', NULL, 3),
(544, 4, 'Where do the speakers most likely work?', 'D', 'At a law office', 'At a supermarket', 'At a medical clinic', 'At a recreation center', NULL, 3),
(545, 4, 'What are the speakers mainly discussing?', 'B', 'A marketing campaign', 'A new product', 'Some budget cuts', 'Some survey results', NULL, 3),
(546, 4, 'What does the woman imply when she says, \"That would require significant revisions to our scheduling process\"?', 'A', 'She doubts a change will be implemented.', 'She thinks more staff should be hired.', 'She needs more time to make a decision.', 'She believes some data is incorrect.', NULL, 3),
(547, 4, 'Why did the woman miss a meeting?', 'D', 'She was not feeling well.', 'She was on a business trip.', 'She was speaking with a client.', 'She did not receive the invitation.', NULL, 3),
(548, 4, 'What is the woman confused about?', 'B', 'The details of an assignment', 'A reimbursement process', 'The terms of a contract', 'A travel itinerary', NULL, 3),
(549, 4, 'According to the man, what should the woman do?', 'C', 'Reset the password for her computer', 'Talk to the organizer of the meeting', 'Consult the electronic version of a document', 'Research the history of an account', NULL, 3),
(550, 4, 'What is the woman an expert in?', 'B', 'Gardening', 'Nutrition', 'Appliance repair', 'Fitness training', NULL, 3),
(551, 4, 'What does the woman recommend?', 'A', 'Substituting ingredients', 'Using appropriate tools', 'Changing an exercise routine', 'Scheduling regular maintenance', NULL, 3),
(552, 4, 'According to the woman, where can listeners find more information?', 'B', 'On a television show', 'On a Web site', 'In a magazine', 'In a book', NULL, 3),
(553, 4, 'What does the woman say about the man\'s job performance?', 'A', 'He is respected by his colleagues.', 'He always meets his deadlines.', 'He has good ideas for new projects.', 'He has increased company profits.', NULL, 3),
(554, 4, 'What does the woman ask the man to do?', 'C', 'Attend a trade show', 'Join a leadership council', 'Mentor a colleague', 'Accept a new position', NULL, 3),
(555, 4, 'When will the speakers meet again?', 'B', 'Tomorrow', 'Next week', 'Next month', 'Next quarter', NULL, 3),
(556, 4, 'What does the man ask the women about?', 'D', 'The types of projects assigned', 'The backgrounds of the applicants', 'The status of training materials', 'The location of an orientation', NULL, 3),
(557, 4, 'What does the man say about last year\'s internship program?', 'D', 'Some new products were developed.', 'Some information was unclear.', 'There were not enough supplies.', 'There were a large number of applicants.', NULL, 3);
INSERT INTO `exam_question` (`question_id`, `exam_id`, `content`, `correct_answer`, `option_1`, `option_2`, `option_3`, `option_4`, `passage_id`, `listening_id`) VALUES
(558, 4, 'What does the men say he is pleased about?', 'B', 'The summer schedule', 'The careful planning', 'The deadline extension', 'The approval process', NULL, 3),
(559, 4, 'What type of business does the woman work for?', 'B', 'A moving company', 'A real estate agency', 'An insurance firm', 'An equipment rental service', NULL, 3),
(560, 4, 'What is the woman concerned about?', 'B', 'Shipping delays', 'New regulations', 'An increase in competition', 'A shortage of staff', NULL, 3),
(561, 4, 'What does the woman emphasize about her company?', 'D', 'The affordable prices', 'The number of branch offices', 'The user-friendly Web site', 'The customer service', NULL, 3),
(562, 4, 'What type of event are the speakers discussing?', 'C', 'A shareholders\' meeting', 'A press conference', 'A job fair', 'A product demonstration', NULL, 3),
(563, 5, 'Ms. Durkin asked for volunteers to help --------------- with the employee fitness program.', 'B', 'she', 'her', 'hers', 'herself', 12, NULL),
(564, 5, 'Lasner Electronics\' staff have extensive -----------of current hardware systems.', 'C', 'know', 'known', 'knowledge', 'knowledgeable', 12, NULL),
(565, 5, '----a year, Tarrin Industrial Supply audits the accounts of all of its factories.', 'A', 'Once', 'Immediately', 'Directly', 'Yet', 12, NULL),
(566, 5, 'Ms. Pham requested a refund------------the coffeemaker she received was damaged.', 'D', 'despite', 'why', 'concerning', 'because', 12, NULL),
(567, 5, 'Information------------the artwork in the lobby is available at the reception desk.', 'B', 'across', 'about', 'upon', 'except', 12, NULL),
(568, 5, 'With the Gema XTI binoculars, users can ------------ see objects that are more than 100 meters away.', 'C', 'ease', 'easy', 'easily', 'easier', 12, NULL),
(569, 5, 'The Physical Therapy Association is committed to keeping costs-------------for its certification programs.', 'A', 'affordable', 'permitted', 'cutting', 'necessary', 12, NULL),
(570, 5, 'Mr. Brennel----------positions in various areas of the company before he became president.', 'D', 'occupation', 'occupational', 'occupying', 'occupied', 12, NULL),
(571, 5, 'To remain on schedule, editors must submit all------------to the book to the authors by Friday.', 'C', 'ideas', 'essays', 'revisions', 'suggestions', 12, NULL),
(572, 5, '----------------------industry professionals are allowed to purchase tickets to the Kuo Photography Fair.', 'A', 'Only', 'Until', 'Unless', 'Quite', 12, NULL),
(573, 5, 'At Pharmbeck’s banquet, Mr. Jones-------------a trophy for his performance in this year’s quality-improvement initiative.', 'A', 'accepted', 'congratulated', 'nominated', 'hoped', 12, NULL),
(574, 5, 'Ms. Suto claims that important market trends become--------------with the use of data analysis.', 'C', 'predict', 'prediction', 'predictable', 'predictably', 12, NULL),
(575, 5, 'One of Grommer Consulting’s goals is to enhance the relationship------------salespeople and their customers.', 'D', 'inside', 'within', 'around', 'between', 12, NULL),
(576, 5, 'Depending on your answers to the survey, we ------------- you to collect additional information.', 'A', 'may call', 'are calling', 'have been called', 'must be calling', 12, NULL),
(577, 5, '--------------- Jemburger opened its newest franchise, the first 100 customers were given free hamburgers.', 'B', 'Now', 'When', 'As if', 'After all', 12, NULL),
(578, 5, 'Please include the serial number of your product in any ------------ with the customer service department.', 'B', 'corresponds', 'correspondence', 'correspondingly', 'correspondent', 12, NULL),
(579, 5, 'The award-winning film Underwater Secrets promotes awareness ------------- ocean pollution and its effects on our planet.', 'A', 'of', 'to', 'from', 'with', 12, NULL),
(580, 5, 'BYF Company specializes in ------------ promotional items to help companies advertise their brand.', 'B', 'personally', 'personalized', 'personality', 'personalizes', 12, NULL),
(581, 5, '-------------- the rent increase is less than 2 percent, Selwin Electrical Supply will continue to lease the space.', 'A', 'As long as', 'Along with', 'Not only', 'Otherwise', 12, NULL),
(582, 5, 'Belden Hospital’s chief of staff meets regularly with the staff to ensure that procedures ------------ correctly.', 'D', 'to be performed', 'would have performed', 'had been performed', 'are being performed', 12, NULL),
(583, 5, 'Any requests for time off should be addressed to the ------------ department supervisor.', 'B', 'urgent', 'appropriate', 'subsequent', 'deliverable', 12, NULL),
(584, 5, 'World Fish Supply delivers the freshest fish possible thanks to innovative ----------------- and shipping methods.', 'D', 'preserves', 'preserved', 'preserve', 'preservation', 12, NULL),
(585, 5, 'Company executives are currently reviewing the annual budget ------------- submitted to them by the Financial Planning department.', 'A', 'requirements', 'deliveries', 'developers', 'qualities', 12, NULL),
(586, 5, 'Even the CEO had to admit that Prasma Designs’ win was ------------ the result of fortunate timing.', 'C', 'parts', 'parted', 'partly', 'parting', 12, NULL),
(587, 5, 'Mr. Singh took notes on ------------- the focus group discussed during the morning session.', 'D', 'each', 'several', 'another', 'everything', 12, NULL),
(588, 5, 'Last year, Tadaka Computer Solutions ranked third --------------- in regional earnings.', 'B', 'together', 'overall', 'consecutively', 'generally', 12, NULL),
(589, 5, '--------------- the popularity of the BPT39 wireless speaker, production will be increased fivefold starting next month.', 'D', 'On behalf of', 'Whether', 'Moreover', 'As a result of', 12, NULL),
(590, 5, 'Zypo Properties has just signed a lease agreement with the law firm ------------ offices are on the third floor.', 'C', 'how', 'what', 'whose', 'wherever', 12, NULL),
(591, 5, '------------- events this year caused profits in the second and third quarters to differ significantly from original projections.', 'D', 'Total', 'Marginal', 'Representative', 'Unforeseen', 12, NULL),
(592, 5, 'The timeline for the pathway lighting project was extended to ------------- input from the environmental commission.', 'D', 'use up', 'believe in', 'make into', 'allow for', 12, NULL),
(593, 5, '', 'A', 'Throughout the trial, you pay nothing and sign no contract.', 'Weight-lifting classes are not currently available.', 'A cash deposit is required when you sign up for membership.', 'All questions should be e-mailed to customerservice@gsgym.com.', 13, NULL),
(594, 5, '', 'D', 'not even', 'almost', 'over', 'less than', 13, NULL),
(595, 5, '', 'B', 'justly', 'regularly', 'evenly', 'simply', 13, NULL),
(596, 5, '', 'C', 'extend', 'renew', 'cancel', 'initiate', 13, NULL),
(597, 5, '', 'A', 'reasons', 'origins', 'senses', 'contributions', 14, NULL),
(598, 5, '', 'C', 'were required', 'require', 'are required', 'are requiring', 14, NULL),
(599, 5, '', 'B', 'Those', 'They', 'I', 'It', 14, NULL),
(600, 5, '', 'B', 'Hanson-Roves ensures the privacy of your health information.', 'Absences may be caused by a number of factors.', 'You should then explain why a physician’s note is not available.', 'Take note of the duties you were originally assigned.', 14, NULL),
(601, 5, 'Where does Ms. Brown most likely work?', 'A', 'At an accounting firm', 'At an architectural firm', 'At a Web design company', 'At a market research company', 15, NULL),
(602, 5, 'What is Ziva asked to do?', 'C', 'Reply to a text message', 'Create a portfolio', 'Set up a meeting', 'Send a work sample', 15, NULL),
(603, 5, 'What does Mr. Muro want Ms. Santos to do?', 'A', 'Process some orders', 'Make a hiring decision', 'Reschedule a meeting', 'Talk to a job candidate', 16, NULL),
(604, 5, 'At 9:36 A.M., what does Mr. Muro mean when he writes, “I know”?', 'A', 'He is also surprised by the company’s growth.', 'He thinks salaries should be higher.', 'He has met Ms. Crenshaw before.', 'He is certain his bus will arrive in', 16, NULL),
(605, 5, '131.', 'A', 'have been improved', 'were improving', 'will improve', 'improved', 17, NULL),
(606, 5, '132.', 'B', 'varying', 'varies', 'vary', 'variation', 17, NULL),
(607, 5, '133.', 'C', 'proposal', 'contract', 'impression', 'upgrade', 17, NULL),
(608, 5, '134.', 'C', 'Supervisors completed a tour of the plant yesterday.', 'Unfortunately, the installation cost more than we had anticipated.', 'As you are aware, our industry is increasingly competitive.', 'All personnel must be trained on the new equipment by the end of the month.', 17, NULL),
(609, 5, '135.', 'C', 'still', 'nowhere', 'soon', 'evenly', 18, NULL),
(610, 5, '136.', 'B', 'As a result', 'To demonstrate', 'Otherwise', 'However', 18, NULL),
(611, 5, '137.', 'D', 'Marketing professionals give conflicting advice.', 'Traditional methods have the best impact.', 'We will develop a diverse plan for your business.', 'We have recently changed our terms of service.', 18, NULL),
(612, 5, '138.', 'A', 'optimal', 'optimize', 'optimization', 'optimum', 18, NULL),
(613, 5, 'According to the woman, what will happen next week?', 'A', 'A) A renovation project will begin.', 'B) A company will move to a new location.', 'C) Some technology will be updated.', 'D) Some new employees will be trained.', NULL, 4),
(614, 5, 'What does the man recommend?', 'A', 'A) Ordering some equipment', 'B) Printing some instructions', 'C) Donating some furniture', 'D) Arranging a catered meal', NULL, 4),
(615, 5, 'What does the woman say she will do?', 'A', 'A) Meet a client', 'B) Research some options', 'C) Make a presentation', 'D) Sign a contract', NULL, 4),
(616, 5, 'Where do the speakers most likely work?', 'A', 'A) At a restaurant', 'B) At a farm', 'C) On a fishing boat', 'D) At a public park', NULL, 4),
(617, 5, 'What does Brian give to Liam?', 'A', 'A) Some gloves', 'B) Some bags', 'C) A plastic bucket', 'D) A clipboard', NULL, 4),
(618, 5, 'According to Brian, what is important?', 'A', 'A) Using sunscreen lotion', 'B) Labeling some items', 'C) Following a schedule', 'D) Drinking water', NULL, 4),
(619, 5, 'Who most likely is the man?', 'A', 'A) An event coordinator', 'B) A book publisher', 'C) A city official', 'D) A podcast host', NULL, 4),
(620, 5, 'What does the woman say is special about a flower?', 'A', 'A) It is resistant to insects.', 'B) It has an unusual color.', 'C) It can bloom for a long time.', 'D) It has a unique smell.', NULL, 4),
(621, 5, 'What will happen next month?', 'A', 'A) A botanical show will be held.', 'B) A public garden will open.', 'C) An experiment will be conducted.', 'D) A gardening class will be offered.', NULL, 4),
(622, 5, 'What does the woman propose doing?', 'A', 'A) Hiring a computer technician', 'B) Using a training application', 'C) Replacing some printers', 'D) Changing business hours', NULL, 4),
(623, 5, 'What is the man concerned about?', 'A', 'A) Scheduling delays', 'B) Employee satisfaction', 'C) The cost of a product', 'D) The quality of a product', NULL, 4),
(624, 5, 'According to the woman, what can be found on a Web site?', 'A', 'A) A company address', 'B) Customer reviews', 'C) A chat feature', 'D) Discount coupons', NULL, 4),
(625, 5, 'What are the speakers mainly discussing?', 'A', 'A) A presenter at an event', 'B) End-of-year bonuses', 'C) Vacation requests', 'D) An applicant for a new role', NULL, 4),
(626, 5, 'According to the speakers, what has Amanda Diop accomplished?', 'A', 'A) She secured a business deal.', 'B) She completed a professional certification.', 'C) She won an industry award.', 'D) She reduced production costs.', NULL, 4),
(627, 5, 'What does the woman say she will do?', 'A', 'A) Submit some documents', 'B) Reserve a venue', 'C) Calculate a budget', 'D) Check some references', NULL, 4),
(628, 5, 'What is the topic of the conversation?', 'A', 'A) A hiring initiative', 'B) A tax proposal', 'C) A volunteer opportunity', 'D) A community festival', NULL, 4),
(629, 5, 'What is Ms. Haddad excited about?', 'A', 'A) Attracting international visitors', 'B) Increasing employment opportunities', 'C) Installing bicycle lanes', 'D) Improving a health-care facility', NULL, 4),
(630, 5, 'What concern does the man point out?', 'A', 'A) Some equipment is missing.', 'B) A project may be understaffed.', 'C) Some safety guidelines are unclear.', 'D) Some parking spaces may be lost.', NULL, 4),
(631, 5, 'Who is the woman scheduled to meet with?', 'A', 'A) A company lawyer', 'B) A senior partner', 'C) A prospective employee', 'D) A potential customer', NULL, 4),
(632, 5, 'What does the man remind the woman about?', 'A', 'A) A luggage restriction', 'B) A required signature', 'C) An online guidebook', 'D) A refund policy', NULL, 4),
(633, 5, 'What does the man agree to do?', 'A', 'A) Look up a phone number', 'B) Arrange for a car rental', 'C) File an expense report', 'D) Forward an e-mail', NULL, 4),
(634, 5, 'Where are the speakers?', 'A', 'A) At an electronics store', 'B) At a trade show', 'C) At a seminar', 'D) At an award ceremony', NULL, 4),
(635, 5, 'What does the woman mean when she says, “we have about 200 employees”?', 'A', 'A) A product would not be useful for her company.', 'B) She is looking to hire a manager.', 'C) Her business has recently become successful.', 'D) Employees will need to be trained.', NULL, 4),
(636, 5, 'What does the man give to the woman?', 'A', 'A) A regional map', 'B) A name tag', 'C) A resume', 'D) A chart', NULL, 4),
(637, 5, 'Who most likely are the speakers?', 'A', 'A) Plumbers', 'B) Commercial architects', 'C) Road repair contractors', 'D) Landscapers', NULL, 4),
(638, 5, 'Why will a project be rescheduled?', 'A', 'A) Rainy weather is expected.', 'B) A design requires revisions.', 'C) Some supplies have not arrived.', 'D) A crew member is not available.', NULL, 4),
(639, 5, 'What will the speakers most likely do on Monday?', 'A', 'A) Finalize a contract', 'B) Train some employees', 'C) Move some vehicles', 'D) Provide some consultations', NULL, 4),
(640, 5, 'Where do the speakers most likely work?', 'A', 'A) At a bookstore', 'B) At a dry cleaning business', 'C) At a bakery', 'D) At a factory', NULL, 4),
(641, 5, 'What does the man imply when he says, “employees have to carry the batches across the room”?', 'A', 'A) A machine is malfunctioning.', 'B) A process is time-consuming.', 'C) Salaries should be increased.', 'D) More workers should be hired.', NULL, 4),
(642, 5, 'What will the man show the woman?', 'A', 'A) A cost estimate', 'B) A floor plan', 'C) A schedule', 'D) A catalog', NULL, 4),
(643, 5, 'What department do the speakers work in?', 'A', 'A) Legal', 'B) ', 'C) Human Resources', 'D) Information Technology', NULL, 4),
(644, 5, 'Look at the graphic. Which quantity needs to be changed?', 'A', 'A) 20', 'B) 35', 'C) 15', 'D) 10', NULL, 4),
(645, 5, 'What does the woman ask about?', 'A', 'A) A refund', 'B) A signature', 'C) A meeting location', 'D) A delivery date', NULL, 4),
(646, 5, 'What type of event are the speakers discussing?', 'A', 'A) A retirement party', 'B) A wedding', 'C) A garden show', 'D) A grand opening', NULL, 4),
(647, 5, 'According to the woman, what has caused a problem?', 'A', 'A) An invoice error', 'B) A rainstorm', 'C) A supply shortage', 'D) A reservation cancellation', NULL, 4),
(648, 5, 'Look at the graphic. Which flowers will be used in the arrangements?', 'A', 'A) Lilies', 'B) Tulips', 'C) Roses', 'D) Orchids', NULL, 4),
(649, 5, 'What is the man most likely planning to do?', 'A', 'A) Sell a shop', 'B) Expand warehouse space', 'C) Replace a sign', 'D) Install air-conditioning', NULL, 4),
(650, 5, 'Look at the graphic. Which part of the storefront does the man say is historic?', 'A', 'A) Part 1', 'B) Part 2', 'C) Part 3', 'D) Part 4', NULL, 4),
(651, 5, 'What will the woman do next?', 'A', 'A) Recommend a paint color', 'B) Inspect some lighting', 'C) Measure a wall', 'D) Take some photographs', NULL, 4),
(652, 5, '131', 'A', 'A) specially', 'B) specialize', 'C) special', 'D) specializing', 19, NULL),
(653, 5, '132 ', 'B', 'A) furniture', 'B) appliances', 'C) refund', 'D) tools', 19, NULL),
(654, 5, '133', 'C', 'A) speak', 'B) spoken', 'C) is speaking', 'D) to speak', 19, NULL),
(655, 5, '134 ', 'D', 'A) He can schedule a convenient time.', 'B) He began working here yesterday.', 'C) He can meet you at 11:00 a.m.', 'D) He recently moved to Dellwyn.', 19, NULL),
(656, 5, '139', 'B', 'A) agree', 'B) vary', 'C) wait', 'D) decline', 20, NULL),
(657, 5, '140', 'C', 'A) receiving', 'B) having received', 'C) received', 'D) will be received', 20, NULL),
(658, 5, '141', 'A', 'A) The updated price list will be available on March 20.', 'B) We apologize for this inconvenience.', 'C) Your orders will be shipped after April 17.', 'D) We are increasing prices because of rising costs.', 20, NULL),
(659, 5, '142', 'A', 'A) exceptionally', 'B) exception', 'C) exceptional', 'D) exceptionalism', 20, NULL),
(660, 5, '143', 'C', 'A) patients', 'B) students', 'C) customers', 'D) teammates', 21, NULL),
(661, 5, '144', 'A', 'A) If you need more time, please let me know.', 'B) Unfortunately, I do not have adequate shelf space at this time.', 'C) I would like to show you some of my own designs.', 'D) The reasonable prices also make your pieces a great value.', 21, NULL),
(662, 5, '145', 'D', 'A) include', 'B) double', 'C) repeat', 'D) insure', 21, NULL),
(663, 5, '146', 'A', 'A) us', 'B) you', 'C) we', 'D) these', 21, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_result`
--

DROP TABLE IF EXISTS `exam_result`;
CREATE TABLE IF NOT EXISTS `exam_result` (
  `result_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `listening_score` int(11) DEFAULT NULL,
  `reading_score` int(11) DEFAULT NULL,
  `total_score` int(11) NOT NULL,
  `time` date NOT NULL,
  PRIMARY KEY (`result_id`),
  KEY `User_id` (`user_id`),
  KEY `FK_exam1` (`exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exam_result`
--

INSERT INTO `exam_result` (`result_id`, `user_id`, `exam_id`, `listening_score`, `reading_score`, `total_score`, `time`) VALUES
(8, 1, 1, NULL, 5, 5, '2025-05-24'),
(9, 1, 1, NULL, 5, 5, '2025-05-24'),
(10, 1, 1, NULL, 5, 5, '2025-05-24'),
(11, 1, 1, NULL, 5, 5, '2025-05-24'),
(12, 1, 1, NULL, 5, 5, '2025-05-24'),
(13, 1, 1, NULL, 10, 10, '2025-05-24'),
(14, 1, 1, NULL, 5, 5, '2025-05-24'),
(15, 1, 4, 25, NULL, 25, '2025-05-24'),
(16, 1, 4, 5, NULL, 5, '2025-05-24'),
(17, 1, 4, 5, NULL, 5, '2025-05-24'),
(18, 1, 5, 5, NULL, 5, '2025-05-24'),
(19, 1, 5, 5, NULL, 5, '2025-05-24'),
(20, 1, 5, 5, NULL, 5, '2025-05-24'),
(21, 1, 5, 5, NULL, 5, '2025-05-24'),
(22, 1, 5, 5, NULL, 5, '2025-05-24'),
(23, 1, 5, 5, NULL, 5, '2025-05-24'),
(24, 1, 5, 5, NULL, 5, '2025-05-24'),
(25, 1, 5, 5, NULL, 5, '2025-05-24'),
(26, 1, 5, 5, NULL, 5, '2025-05-24'),
(27, 1, 5, 5, NULL, 5, '2025-05-24'),
(28, 1, 5, 5, NULL, 5, '2025-05-24'),
(29, 1, 5, 20, 5, 25, '2025-05-24'),
(30, 1, 5, 20, 5, 25, '2025-05-24'),
(31, 1, 5, 20, NULL, 20, '2025-05-24'),
(32, 1, 5, 20, 5, 25, '2025-05-24'),
(33, 1, 5, 20, 5, 25, '2025-05-24'),
(34, 1, 4, 20, NULL, 20, '2025-05-24'),
(35, 1, 5, 20, 5, 25, '2025-05-24'),
(36, 1, 5, 20, 5, 25, '2025-05-24'),
(37, 1, 5, 15, 5, 20, '2025-05-24'),
(38, 3, 4, 20, NULL, 20, '2025-05-24'),
(39, 3, 1, NULL, 5, 5, '2025-05-25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `listening`
--

DROP TABLE IF EXISTS `listening`;
CREATE TABLE IF NOT EXISTS `listening` (
  `listening_id` int(255) NOT NULL AUTO_INCREMENT,
  `exam_id` int(255) NOT NULL,
  `content` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `audio_url` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`listening_id`),
  KEY `FK` (`exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `listening`
--

INSERT INTO `listening` (`listening_id`, `exam_id`, `content`, `audio_url`) VALUES
(1, 4, 'Directions: You will hear some talks given by a single speaker. You will be asked to answer three questions about what the speaker says in each talk. Select the best response to each question and mark the letter (A), (B), (C), or (D) on your answer sheet. The talks will not be printed in your test book and will be spoken only one time.', 'audio/Listening_1.mp3'),
(2, 4, 'Directions: You will hear some conversations between two or more people. You will be asked to answer three questions about what the speakers say in each conversation. Select the best response to each question and mark the letter (A), (B), (C), or (D) on your answer sheet. The conversations will not be printed in your test book and will be spoken only one time.', 'audio/Listening_2.mp3'),
(3, 4, 'Directions: You will hear some conversations between two or more people. You will be asked to answer three questions about what the speakers say in each conversation. Select the best response to each question and mark the letter (A), (B), (C), or (D) on your answer sheet. The conversations will not be printed in your test book and will be spoken only one time.', 'audio/Listening_3.mp3'),
(4, 5, 'Directions: You will hear some conversations between two or more people. You will be asked to answer three questions about what the speakers say in each conversation. Select the best response to each question and mark the letter (A), (B), (C), or (D) on your answer sheet. The conversations will not be printed in your test book and will be spoken only one time.', 'audio/Listening_full_1.mp3');

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
  `content` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`passage_id`),
  KEY `FK_Exam11` (`exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(11, 1, 'Delroy Gerew (1:29 PM):\r\nHi, Ms. Chichester. we\'d like to order another 10 shirts, featuring the company\'s name, Magnalook, and its logo. We need four small, two medium, and four large sizes. Could you fill the order by Friday?\r\nNina Chichester (1:32 P.Nl.):\r\nThat\'s two days from today, so a $75 rush-order fee will be added.\r\nDelroy Gerew (1:34 PM):\r\nHow can we avoid the fee?\r\nNina Chichester (1:36 PM):\r\nBy choosing the standard 5-day production option. Your order would be ready Monday of next week.\r\nDelroy Gerew (1:38 P.M.):\r\nI guess it can\'t be helped. Since we have employees starting this Friday and you open at 8:00 AM, can I pick up the shirts at that time?\r\nNina Chichester (1:39 P.M.):\r\nPick-up time is normally after 1:00 PM, but I\'ll see to it they\'re ready by 8:00 AM.\r\nDelroy Gerew (1 :41 RM):\r\nThank you. Actually. my assistant will be picking them up.\r\nNina Chichester (1:42 P.M.):\r\nThat\'s fine. Could you please e-mail me your logo again? The computer on which I had it stored crashed the other day and is awaiting repair.\r\nDelroy Gerew (1:44 PM):\r\nWill do. Thanks, and please charge the credit card you have on file for us.'),
(12, 5, 'In the Reading test, you will read a variety of texts and answer several different types of reading comprehension questions. The entire Reading test will last 75 minutes. There are three parts, and directions are given for each part. You are encouraged to answer as many questions as possible within the time allowed.\r\nYou must mark your answers on the separate answer sheet. Do not write your answers in your test book.\r\nPART 5\r\nDirections: A word or phrase is missing in each of the sentences below. Four answer choices are given below each sentence. Select the best answer to complete the sentence. Then mark the letter (A), (B), (C), or (D) on your answer sheet.'),
(13, 5, 'With Global Strength Gym\'s 30-day trial period, you get the opportunity to try out our classes, equipment, and facilities ____(131)_____ . It\'s completely risk-free! To sign up, we require your contact information and payment details, but you will only be charged if you are a member for ____(132)_____ 30 days. If you decide within this time that you no longer want to be a member of Global Strength, ____(133)_____ visit our Web site at www.gsgym.com. On the Membership page, elect to ____(134)_____ your membership and enter the necessary information. It\'s that easy!'),
(14, 5, 'As a Hanson-Roves employee, you are entitled to sick absences, during which you will be paid for time off work for health ____(135)_____. To avoid deductions to your pay you ____(136)_____ to provide a physician-signed note as documentation of your illness ____(137)_____ should include the date you were seen by the doctor, a statement certifying that you are unable to perform the duties of your position, and your expected date of return. Your supervisor will then forward the documentation to Human Resources ____(138)_____. Employee health records can be accessed only by those with a valid business reason for reviewing them.'),
(15, 5, 'Chakia Brown [3:32 P.M.]\r\nHi, Ziva. I just met with the Han board of directors, and they\'re interested in our redesign proposal for their downtown office buildings. Amy Han asked for another work sample, but I didn\'t have the right portfolio with me. I\'m heading to another meeting, so please have a messenger deliver a copy of the Grainger Centre files to her. Include the full set of plans. Thanks!'),
(16, 5, 'Louisa Santos 9:30A.M.\r\nKenji, where are you? The job candidates are here.\r\nKenji Muro 9:31A.M.\r\nSorry! The bridge is closed. My bus had to take a detour. I should be there in 30 minutes. Please start without me.\r\nLouisa Santos 9:34A.M.\r\nOK. I\'m going to interview Elena Crenshaw first.\r\nKenji Muro 9:34A.M.\r\nGood. She\'s the one with experience at another T-shirt company.\r\nLouisa Santos 9:35A.M.\r\nYes. Can you believe our small company has grown so much that we need to hire someone just to process orders?\r\nKenji Muro 9:36A.M.\r\nI know! OK. I\'ll see you soon.'),
(17, 5, 'We are pleased to announce that the installation of the new manufacturing equipment in our main plant has been completed. The new machines ____(131)_____ work flow by allowing for flexibility in production. With six mixing tanks of ____(132)_____ sizes, we expect to be able to fill a wider range of orders, from small to very large. This ____(133)_____ is an important way to ensure that Balm Manufacturing continues to be a leader in the fragrance industry. ____(134)_____. Jim Martel, who is organizing this effort, will contact each of you soon with details.'),
(18, 5, 'Marketing your business can be confusing. Newspapers and magazines are ____(135)_____ useful venues for advertising ____(136)_____, social media platforms have become even more critical marketing outlets. Kate Wei Communications utilizes both traditional outlets and the latest communication platforms ____(137)_____. In addition to exceptional print services, Kate Wei Communications has the expertise to help you ____(138)_____ your online presence. Why wait? Choose our award-winning firm to strengthen your company\'s image today!'),
(19, 5, 'To: Myung-Hee Hahn\r\nFrom: Dellwyn Home Store\r\nDate: January 15\r\nSubject: Order update\r\n\r\nDear Ms. Hahn,\r\n\r\nYour ____(131)_____ order of a red oak dining table and six matching chairs arrived at our store this morning. We would now like to arrange for the delivery of the ____(132)_____. Please call us at 517-555-0188 and ask ____(133)_____ to Coleman Cobb, our delivery manager ____(134)_____\r\n\r\nCustomer Service, Dellwyn Home Store'),
(20, 5, 'To: All Customers\r\nFrom: asquires@lightidea.com\r\nDate: March 6\r\nSubject: Information\r\n\r\nDear Light Idea Customers,\r\n\r\nLight Idea is enacting a price increase on select energy-efficient products, effective April 17. Specific product pricing will ____(139)_____. Please contact your sales representative for details and questions.\r\n\r\nThe last date for ordering at current prices is April 16. All orders ____(140)_____ after this date will follow the new price list ____(141)_____. Customers will be able to find this on our Web site.\r\n\r\nWe will continue to provide quality products and ____(142)_____ service to our valued customers. Thank you for your business.\r\n\r\nSincerely,\r\nArvin Squires\r\nHead of Sales, Light Idea'),
(21, 5, '\r\nTo: Jang-Ho Kwon <jkwon@newart.nz>\r\nFrom: Kenneth Okim <k.okim@okimjewelry.nz>\r\nSubject: Good news\r\nDate: 30 August\r\n\r\nDear Jang-Ho,\r\n\r\nThank you for the shipment last month of 80 units of your jewelry pieces. I am happy to report that they have been selling very well in my shop. My ____(143)_____ love the colourful designs as well as the quality of your workmanship____(144)_____.\r\n\r\nI would like to increase the number of units I order from you. Would you be able to ____(145)_____my order for the September shipment?\r\n\r\nFinally, I would like to discuss the possibility of featuring your work exclusively in my store. I believe that I could reach your target audience best and that the agreement would serve ____(146)_____both very well. I look forward to hearing from you.\r\n\r\nBest regards,\r\nKenneth Okim\r\nOkim Jewelry');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `email`, `password`, `full_name`, `phone`, `role`) VALUES
(1, 'naruma262', 'Nar@gmail.com', '123', 'Hồ Thái', '0814305505', 'user'),
(2, 'naruma', 'narumal262@gmail.com', '123', 'Hồ Quốc Thái', '0814305505', 'user'),
(3, 'NaN', 'nhivanar@gmail.com', 'nhivanar', 'Nhi Va Nar', '0814305505', 'admin');

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `exam_question`
--
ALTER TABLE `exam_question`
  ADD CONSTRAINT `FK_Exam` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_lis` FOREIGN KEY (`listening_id`) REFERENCES `listening` (`listening_id`),
  ADD CONSTRAINT `Fk_rdpass` FOREIGN KEY (`passage_id`) REFERENCES `reading_passage` (`passage_id`);

--
-- Các ràng buộc cho bảng `exam_result`
--
ALTER TABLE `exam_result`
  ADD CONSTRAINT `FK_exam1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_userid` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `listening`
--
ALTER TABLE `listening`
  ADD CONSTRAINT `FK` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
