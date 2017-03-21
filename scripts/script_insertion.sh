echo "Creating the database..."
python3 creation_bd.py
echo "Database created.\n"

echo "Starting fasta file..."
python3 parsing_fasta-VF.py
echo "Fasta file finished.\n"

echo "Starting blastout file..."
python3 blastout_VF.py
echo "Blastout file finished.\n"

echo "Starting correspondance file..."
python3 correspondance_VF.py
echo "Correspondance file finished.\n"

echo "Starting family file..."
python3 script_family_VF.py
echo "Famille file finished."
