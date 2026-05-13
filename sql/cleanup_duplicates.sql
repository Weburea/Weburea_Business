-- Remove duplicate dummy data - keep only the 6 original unique work entries
-- This keeps IDs 1,2,3,4 (first batch) and 13,14 (VR/AI items), deletes the rest
DELETE FROM portfolio_works WHERE id NOT IN (1, 2, 3, 4, 13, 14);
