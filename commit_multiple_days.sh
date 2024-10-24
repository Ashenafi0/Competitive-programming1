#!/bin/bash

# Set the start date and number of commits per day
START_DATE="2024-10-24"
NUM_COMMITS_PER_DAY=2

# List of files to commit (You can modify this to include specific files or all files)
FILES_TO_COMMIT=$(ls)  # List all files in the current directory

# Loop to create commits for each day
for i in {0..38}  # Create commits for 6 days, adjust this number as needed
do
  # Calculate the date for this commit
  CURRENT_DATE=$(date -I -d "$START_DATE + $i day")
  
  for j in $(seq 1 $NUM_COMMITS_PER_DAY)
  do
    # Commit message for each commit
    COMMIT_MSG="Commit $((i * NUM_COMMITS_PER_DAY + j)): Changes for $CURRENT_DATE"

    # Iterate through files and commit each file
    for FILE in $FILES_TO_COMMIT
    do
      # Stage the file
      git add "$FILE"

      # Set the commit date and commit the file
      GIT_COMMITTER_DATE="$CURRENT_DATE 12:00:00" git commit --date "$CURRENT_DATE 12:00:00" -m "$COMMIT_MSG"
    done
  done
done
