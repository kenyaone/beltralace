-- Seed the reviews table with the 5 real testimonials that were
-- previously hardcoded in frontend/views/home.php loadTestimonials().
--
-- Run once after scripts/reviews-schema.sql. Not idempotent —
-- re-running will insert duplicates. TRUNCATE the table first if
-- you need to re-seed.

INSERT INTO reviews (name, email, review, rating, role, is_published) VALUES
('Ian Cooper', NULL,
 'I''m really enjoying my lessons with Belha. She teaches in a pragmatic way which means we cover all the important things and I feel we are working towards me learning as quickly as we can. Highly recommended.',
 5, 'Swahili Student', 1),
('Sheena', NULL,
 'I have loved working with Belha! I was attempting to learn Swahili on my own using apps, but with her help, I am learning much more quickly and able to have basic conversations after only a few months.',
 5, 'Swahili Student', 1),
('Malcolm Macnaughton', NULL,
 'Belha is a brilliant Swahili teacher, understanding the varying needs of students of all ages. Belha adapts her methods and the content of lessons to suit her students — this is not a ''one size fits all'' approach.',
 5, 'Swahili Student', 1),
('Pam', NULL,
 'Learning Swahili with Belha is a treat — she very soon worked out what energy we could give to learning in the midst of demanding work and family commitments. She is unfailingly patient and kind.',
 5, 'Swahili Student', 1),
('Amileena Hope', NULL,
 'I enjoyed my French tuition lessons with my teacher. It was quite a memorable experience! Beltralace trainers are very professional and dedicated to their service. I loved it!',
 5, 'French Student', 1);
