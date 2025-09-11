#!/bin/bash

# Script pour convertir des images JPEG en WebP et les renommer séquentiellement

# Configuration
INPUT_DIR="img/salon/new"      # Répertoire source contenant les images JPEG
OUTPUT_DIR="img/salon/webp"    # Répertoire de destination pour les fichiers WebP
QUALITY=85                     # Qualité de la compression WebP (0-100)

# Vérification d'ImageMagick
if ! command -v convert &> /dev/null; then
    echo "ImageMagick n'est pas installé. Installation en cours..."
    sudo apt update && sudo apt install imagemagick -y || { echo "L'installation a échoué"; exit 1; }
fi

# Vérifier que le répertoire source existe
if [ ! -d "$INPUT_DIR" ]; then
    echo "Erreur : Le répertoire source $INPUT_DIR n'existe pas."
    exit 1
fi

# Créer le répertoire de destination s'il n'existe pas
mkdir -p "$OUTPUT_DIR"

# Créer un tableau pour stocker les chemins des fichiers
declare -a IMAGE_FILES

# Utiliser une boucle while pour préserver les espaces dans les noms de fichiers
while IFS= read -r -d '' file; do
    IMAGE_FILES+=("$file")
done < <(find "$INPUT_DIR" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.JPG" -o -iname "*.JPEG" \) -print0)

# Vérifier si des images ont été trouvées
if [ ${#IMAGE_FILES[@]} -eq 0 ]; then
    echo "Aucune image JPEG trouvée dans $INPUT_DIR"
    exit 1
fi

echo "Conversion de ${#IMAGE_FILES[@]} images en format WebP..."

# Initialiser le compteur
count=1

# Traiter chaque image
for image in "${IMAGE_FILES[@]}"; do
    filename="$count.webp"
    output_path="$OUTPUT_DIR/$filename"
    
    echo "🔄 Conversion de \"$(basename "$image")\" en $filename..."
    
    # Convertir l'image en WebP avec la qualité spécifiée
    convert "$image" -quality $QUALITY "$output_path"
    
    # Si la conversion a réussi
    if [ $? -eq 0 ]; then
        echo "✅ Image convertie et enregistrée sous $output_path"
        # Incrémenter le compteur
        ((count++))
    else
        echo "❌ Échec de la conversion de $image"
    fi
done

echo "✨ Terminé ! $((count-1)) images ont été converties en format WebP et renommées séquentiellement."
echo "Les images sont disponibles dans le répertoire $OUTPUT_DIR"

# Afficher les statistiques d'économie d'espace
if [ $((count-1)) -gt 0 ]; then
    echo "📊 Statistiques d'économie d'espace :"
    original_size=$(du -ch "${IMAGE_FILES[@]}" | grep total | cut -f1)
    webp_size=$(du -ch "$OUTPUT_DIR"/* | grep total | cut -f1)
    echo "  Taille originale des JPEG : $original_size"
    echo "  Taille des WebP : $webp_size"
fi
