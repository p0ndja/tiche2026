-- Migration: 002_add_submission_user_info
-- Creates  a user_id column in various submission tables

ALTER TABLE submission ADD COLUMN user_id INT NULL AFTER sub_timestamp;
ALTER TABLE paper_submission ADD COLUMN user_id INT NULL AFTER sub_timestamp;
ALTER TABLE school_submission ADD COLUMN user_id INT NULL AFTER sub_timestamp;
ALTER TABLE senior_submission ADD COLUMN user_id INT NULL AFTER sub_timestamp;
