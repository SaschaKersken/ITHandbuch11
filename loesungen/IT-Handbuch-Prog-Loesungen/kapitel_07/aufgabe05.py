class Animal:

    def __init__(self, name, legs):
        self.name = name
        self.legs = legs

    def __str__(self):
       return f"{self.name}: {self.legs} legs"



if __name__ == '__main__':
    list_of_animals = [
        Animal("dog", 4),
        Animal("snake", 0),
        Animal("bird", 2)
    ]
    list_of_animals = sorted(list_of_animals, key=lambda animal:animal.legs)
    for animal in list_of_animals:
        print(animal)
