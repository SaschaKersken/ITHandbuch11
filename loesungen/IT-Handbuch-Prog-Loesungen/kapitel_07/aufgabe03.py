with open("zahlen.txt", "w") as zahlen_file:
    for i in range(1, 101):
        zahlen_file.write('{:3d}\n'.format(i))
