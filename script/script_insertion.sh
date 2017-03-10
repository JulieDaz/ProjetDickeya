echo "Starting fasta file..."
python3 parsing_fasta-VF.py
echo "Fasta file finished"
echo "Starting blastout file..."
python3 blastout_VF.py
echo "Blastout file finished."
echo "Starting correspondance file..."
python3 correspondance_VF.py
echo "Correspondance file finished."
echo "Starting family file..."
python3 script_family_VF.py
echo "Famille file finished."
