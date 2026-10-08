"""Analiza un archivo local y devuelve sus metadatos en formato JSON.

Solo usa la librería estándar de Python, por lo que no requiere instalar
Pillow, pytesseract ni ninguna otra dependencia externa.

Uso desde Laravel:

    Process::run(['python3', base_path('app/Python/analyzer.py'), $imagePath]);
"""

import json
import struct
import sys
from pathlib import Path

# Marcadores JPEG "Start Of Frame" que contienen ancho y alto.
JPEG_SOF_MARKERS = {
    0xC0, 0xC1, 0xC2, 0xC3, 0xC5, 0xC6, 0xC7,
    0xC9, 0xCA, 0xCB, 0xCD, 0xCE, 0xCF,
}


def _png_size(data: bytes):
    if len(data) >= 24 and data[12:16] == b'IHDR':
        width, height = struct.unpack('>II', data[16:24])
        return width, height
    return None


def _gif_size(data: bytes):
    if len(data) >= 10:
        width, height = struct.unpack('<HH', data[6:10])
        return width, height
    return None


def _bmp_size(data: bytes):
    if len(data) >= 26:
        width, height = struct.unpack('<ii', data[18:26])
        return width, abs(height)
    return None


def _jpeg_size(data: bytes):
    index = 2  # Se salta el marcador inicial SOI (0xFFD8).

    while index + 9 < len(data):
        if data[index] != 0xFF:
            index += 1
            continue

        marker = data[index + 1]

        # Marcadores que no llevan tamaño de bloque.
        if marker in (0xD8, 0xD9) or 0xD0 <= marker <= 0xD7:
            index += 2
            continue

        block_size = struct.unpack('>H', data[index + 2:index + 4])[0]

        if marker in JPEG_SOF_MARKERS:
            height, width = struct.unpack('>HH', data[index + 5:index + 9])
            return width, height

        index += 2 + block_size

    return None


def image_dimensions(file_path: Path):
    """Devuelve (ancho, alto) leyendo solo la cabecera del archivo."""
    readers = {
        '.png': _png_size,
        '.gif': _gif_size,
        '.bmp': _bmp_size,
        '.jpg': _jpeg_size,
        '.jpeg': _jpeg_size,
    }

    reader = readers.get(file_path.suffix.lower())

    if reader is None:
        return None

    with file_path.open('rb') as handle:
        header = handle.read(65536)

    return reader(header)


def analyze_file(file_path: str) -> dict:
    path = Path(file_path).expanduser()

    if not path.exists():
        return {'error': 'El archivo no existe: {}'.format(path)}

    if not path.is_file():
        return {'error': 'La ruta no es un archivo: {}'.format(path)}

    try:
        size = image_dimensions(path)
    except OSError:
        size = None

    return {
        'status': 'success',
        'file_name': path.name,
        'extension': path.suffix.lower(),
        'size_bytes': path.stat().st_size,
        'size_kb': round(path.stat().st_size / 1024, 2),
        'width': size[0] if size else None,
        'height': size[1] if size else None,
        'absolute_path': str(path.resolve()),
    }


def main(argv) -> int:
    if len(argv) < 2:
        print(json.dumps({'error': 'No se proporciono la ruta del archivo'}))
        return 1

    result = analyze_file(argv[1])

    print(json.dumps(result))

    return 0 if 'error' not in result else 1


if __name__ == '__main__':
    sys.exit(main(sys.argv))
