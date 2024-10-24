#!/bin/bash

# Set the start date and number of commits per day
START_DATE="2024-10-24"
NUM_COMMITS_PER_DAY=2  # You can change this number to commit more files per day
FILES_TO_COMMIT=($(ls))  # Get all files in the current directory (adjust if necessary)

# Calculate total number of commits
TOTAL_COMMITS=${#FILES_TO_COMMIT[@]}
COMMITS_PER_DAY=$NUM_COMMITS_PER_DAY

# Loop through the files and commit them on different days
for ((i = 0; i < TOTAL_COMMITS; i++)); do
  # Calculate the date for this commit (start from START_DATE and increase for each day)
  CURRENT_DATE=$(date -I -d "$START_DATE + $((i / COMMITS_PER_DAY)) day")
  
  # Create a commit message
  COMMIT_MSG="Commit $((i + 1)): Changes for $CURRENT_DATE"

  # Stage the file
  git add "${FILES_TO_COMMIT[$i]}"

  # Set the commit date and commit the file
  GIT_COMMITTER_DATE="$CURRENT_DATE 12:00:00" git commit --date "$CURRENT_DATE 12:00:00" -m "$COMMIT_MSG"
done

# Push the commits to GitHub
git push origin master
